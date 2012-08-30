<?php

class BuildButtonTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'widget'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'build-button';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [BuildButton|INFO] task does things.
Call it with:

  [php symfony BuildButton|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    // $databaseManager = new sfDatabaseManager($this->configuration);
    // $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $this->logSection('yiid', 'Building the button widget');
    
    $this->runTask('yiid:generate-controller', array(), array('application' => $options['application'], 'env' => $options['env']));
    $this->runTask('yiid:generate-widget-config', array(), array('application' => $options['application'], 'env' => $options['env']));

    // run doctrine build task
    $this->runTask('doctrine:build', array("--all-classes"), array('env' => $options['env']));
    // clean up models folder
    $this->runTask('doctrine:clean', array("--no-confirmation"));

    // add i18n-sync
    // $this->runTask('yiid:i18n-sync', array(), array('env' => $options['env']));    

    // build js
    $this->runTask('yiid:build-js', array(), array('application' => $options['application'], 'env' => $options['env']));
    // build css
    $this->runTask('yiid:build-css', array(), array('application' => $options['application'], 'env' => $options['env']));
    
    // Clearing the cache
    $this->runTask('cc');
  }
}
