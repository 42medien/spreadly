<?php

class BuildTask extends sfBaseTask {
  /**
   *
   */
  protected function configure() {
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'platform'),
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
    // create "cache" and "log" folders
    $this->getFilesystem()->mkdirs("cache");
    $this->getFilesystem()->mkdirs("log");

    // clean "cache" and "log" folders
    $this->getFilesystem()->execute("rm -rf cache/*");
    $this->getFilesystem()->execute("rm -rf log/*");

    // build all?
    if ($options['all']) {
      $args = array("--all");
    } else {
      $args = array();
    }

    // create controllers
    $this->runTask('yiid:generate-controller', $args, array('application' => $options['application'], 'env' => $options['env']));
    $this->executeDbTasks($arguments, $options);

    // add i18n-sync
    if ($options['env'] == "dev") {
      $this->runTask('yiid:i18n-sync');
    }

    // build js
    $this->runTask('yiid:build-js', array(), array('application' => $options['application'], 'env' => $options['env']));
    // build css
    $this->runTask('yiid:build-css', array(), array('application' => $options['application'], 'env' => $options['env']));
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

    // generate arguments array
    if ($env == 'dev' || $env == 'staging') {
      // add arguments for the "dev" or "staging" environment
      $args[] = '--all';
      // check if "confirmation" is enabled
      if ($options['no-confirmation']) {
        $args[] = '--no-confirmation';
      }
      $args[] = '--and-load';
    } elseif($env == 'prod') {
      // add arguments for the "prod" environment
      $args[] = '--all-classes';
    } else {
      throw new sfException(sprintf('Module "%s" does not exist.', $env));
    }

    // run doctrine build task
    $this->runTask('doctrine:build', $args, array('env' => $opts['env']));
    // clean up models folder
    $this->runTask('doctrine:clean', array("--no-confirmation"));

    // initialize mongo objects
    if ($env == 'dev' || $env == 'staging') {
      MongoDbConnector::getInstance()->getDatabase("yiid")->drop();
      $this->getFilesystem()->execute("php data/fixtures/initializeMongoObjects.php");
    }

    $this->runTask('cc');
  }
}
