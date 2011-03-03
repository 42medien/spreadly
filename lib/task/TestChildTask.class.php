<?php

class TestChildTask extends sfBaseTask
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
    $this->name             = 'test-child';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [TestChild|INFO] task does things.
Call it with:

  [php symfony TestChild|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $this->log("I'm the ChildTask …");
    $this->log("env: ".$options['env']);
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $database = $databaseManager->getDatabase($options['connection']);
    //$connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    $u = $database->getParameter('username');
    $p = $database->getParameter('password');
    $dsn = $database->getParameter('dsn');
    $results = array();
    preg_match("~host=(\w+)~i", $dsn, $results);
    $h = $results[1];

    $results = array();
    preg_match("~dbname=(\w+)~i", $dsn, $results);
    $d = $results[1];

    $query = "mysql --host=".$h." -u ".$u." -p".$p." ".$d." < i18n.sql";

    $this->log("The query:");
    $this->log($query);
  }
}
