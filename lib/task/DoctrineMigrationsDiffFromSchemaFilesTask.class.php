<?php

class DoctrineMigrationsDiffFromSchemaFilesTask extends sfBaseTask
{
  protected function configure()
  {
    // // add your own arguments here
    // $this->addArguments(array(
    //   new sfCommandArgument('my_arg', sfCommandArgument::REQUIRED, 'My argument'),
    // ));
    
    
    $this->addOptions(array(
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'statistics'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
      new sfCommandOption('from', null, sfCommandOption::PARAMETER_REQUIRED, 'The schema nr. 1'),
      new sfCommandOption('to', null, sfCommandOption::PARAMETER_REQUIRED, 'The schema nr. 2'),
      new sfCommandOption('classes_path', null, sfCommandOption::PARAMETER_OPTIONAL, 'The path to the migration classes', 'lib/migration/doctrine'),

    ));

    $this->namespace        = 'yiid';
    $this->name             = 'generate-migrations-diff-from-schemas';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [DoctrineMigrationsDiffFromSchemaFiles|INFO] task does things.
Call it with:

  [php symfony DoctrineMigrationsDiffFromSchemaFiles|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();
    
    $lRootDir = ProjectConfiguration::getApplicationConfiguration($options['application'], $options['env'], true)->getRootDir();
    $this->logSection('yiid', 'Generating diff from: '.$lRootDir.'/data/sql/'.$options['from']." to: ".$lRootDir.'/data/sql/'.$options['to']);
    Doctrine_Core::generateMigrationsFromDiff($lRootDir.'/'.$options['classes_path'], $options['from'], $options['to']);
  }
}
