<?php

class BuildTask extends sfBaseTask {
  /**
   *
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      new sfCommandOption('no-confirmation', null, sfCommandOption::PARAMETER_NONE, 'Do not prompt for confirmation'),
      new sfCommandOption('all', null, sfCommandOption::PARAMETER_NONE, 'Build all controller')
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'build';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [BuildPlatform|INFO] task does things.
Call it with:

  [php symfony BuildPlatform|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array()) {
    sfContext::createInstance($this->configuration);

    // create "cache" folder
    $this->getFilesystem()->mkdirs("cache");
    $this->getFilesystem()->execute("rm -rf cache/*");

    // clean "log" folder
    if ($options['env'] != "dev") {
      $this->getFilesystem()->mkdirs("log");
      $this->getFilesystem()->execute("rm -rf log/*");
    }

    $this->getFilesystem()->mkdirs("cache/Hydrators");
    $this->getFilesystem()->mkdirs("cache/Proxies");
    $this->getFilesystem()->mkdirs("lib/mongo/Hydrators");
    $this->getFilesystem()->mkdirs("lib/mongo/Proxies");

    // build all?
    if ($options['all']) {
      $args = array("--all");
    } else {
      $args = array();
    }

    // create controllers
    $this->runTask('yiid:generate-controller', $args, array('application' => $options['application'], 'env' => $options['env']));
    $this->runTask('yiid:generate-widget-config', array(), array('application' => $options['application'], 'env' => $options['env']));
    $this->runTask('yiid:generate-batch-config', array(), array('application' => $options['application'], 'env' => $options['env']));
    $this->executeDbTasks($arguments, $options);

    // new arguments array
    $args = array();
    if ($options['no-confirmation']) {
      $args[] = '--no-confirmation';
    }

    // add i18n-sync
    //$this->runTask('yiid:i18n-sync', $args, array('application' => $options['application'], 'env' => $options['env']));

    // build js
    $this->runTask('yiid:build-js', array(), array('application' => $options['application'], 'env' => $options['env']));
    // build css
    $this->runTask('yiid:build-css', array(), array('application' => $options['application'], 'env' => $options['env']));

    if ($options['env'] != "dev") {
      // $this->runTask('yiid:s3-sync', array(), array('env' => $options['env']));
    }
  }

  /**
   *
   */
  protected function executeDbTasks($arguments = array(), $options = array()) {
    $this->logSection('yiid', 'run db tasks');

    // new options array
    $opts = array();
    $env = $opts['env'] = $options['env'];

    // new arguments array
    $args = array();
    if ($options['no-confirmation']) {
      $args[] = '--no-confirmation';
    }

    // generate arguments array
    if ($env == 'dev' || $env == 'staging') {
      // add arguments for the "dev" or "staging" environment
      $args[] = '--all';
      // check if "confirmation" is enabled
      $args[] = '--and-load';
    } elseif($env == 'prod') {
      // add arguments for the "prod" environment
      $args[] = '--all-classes';
      // $args[] = '--and-migrate';
    } else {
      throw new sfException(sprintf('Module "%s" does not exist.', $env));
    }

    // run doctrine build task
    $this->runTask('doctrine:build', $args, array('env' => $opts['env']));
    // clean up models folder
    $this->runTask('doctrine:clean', array("--no-confirmation"));

    // initialize mongo objects
    if ($env == 'dev' || $env == 'staging') {
      if ($options['no-confirmation'] || "y" == $this->ask("Mongo auf dem ".$env.'-System plattmachen? (host: '.sfConfig::get('app_mongodb_host').' collection: '.sfConfig::get('app_mongodb_database_name').") (y/N)")) {
        $this->logSection('mongo tasks', 'i am the mongo killer! now killing:');
        $this->logSection('mongo tasks', '(host: '.sfConfig::get('app_mongodb_host').' collection: '.sfConfig::get('app_mongodb_database_name').')');
        MongoDbConnector::getInstance()->getDatabase(sfConfig::get('app_mongodb_database_name'))->drop();
        $this->logSection('mongo tasks', ' (host: '.sfConfig::get('app_mongodb_host').' collection: '.sfConfig::get('app_mongodb_database_name_stats').')');
        MongoDbConnector::getInstance()->getDatabase(sfConfig::get('app_mongodb_database_name_stats'))->drop();
        $this->runTask('yiid:activity-testdata', array(), array('env' => $opts['env']));
        //$this->getFilesystem()->execute("php data/fixtures/initializeMongoObjects.php");
      }
    }

    $this->runTask('cc');
  }
}