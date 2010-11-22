<?php

class S3SyncTask extends sfBaseTask
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

    $this->namespace        = '';
    $this->name             = 'S3Sync';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [S3Sync|INFO] task does things.
Call it with:

  [php symfony S3Sync|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    // initialize the database connection
    $databaseManager = new sfDatabaseManager($this->configuration);
    $connection = $databaseManager->getDatabase($options['connection'])->getConnection();

    /*
    <exec command="s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/css/ s3://${bucket}/${rev}/css/" checkreturn="true" />
    <exec command="s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/img/ s3://${bucket}/${rev}/img/" checkreturn="true" />
    <exec command="s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/js/100_main/include/ s3://${bucket}/${rev}/js/100_main/include/" checkreturn="true" />


    <exec command="find ./web/js/100_main/include -type f -exec 7z a -tgzip -x\!\*.svn -x\!\*.gz  {}.gz {} \;" checkreturn="true" />
    <exec command="s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'application/javascript' --add-header 'Content-Encoding: gzip' sync web/js/100_main/include/ s3://${bucket}/${rev}/js/100_main/include/" checkreturn="true" />
    <exec command="find ./web/js/100_main/include -name '*.gz' -exec rm {} \;" checkreturn="true" />

    <exec command="find ./web/css -type f -exec 7z a -tgzip  -x\!\*.svn -x\!\*.gz  {}.gz {} \;" checkreturn="true" />
    <exec command="s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'text/css' --add-header 'Content-Encoding: gzip' sync web/css/ s3://${bucket}/${rev}/css/" checkreturn="true" />
    <exec command="find ./web/css -name '*.gz' -exec rm {} \;" checkreturn="true" />
    */
  }
}
