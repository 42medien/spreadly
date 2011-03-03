<?php

class TestBaseTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));

    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 'test-base';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [TestBase|INFO] task does things.
Call it with:

  [php symfony TestBase|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->executeDbTasks($arguments, $options);
  }
  
  protected function executeDbTasks($arguments = array(), $options = array()) {
    $this->log("I'm the BaseTask …");

    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $database = $databaseManager->getDatabase($options['connection']);
    //$connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    // add your code here
    $this->runTask('yiid:test-child', array(), array('application' => $options['application'], 'env' => $options['env']));
    
  }
}
