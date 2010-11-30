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

  /**
   *
   *
   * @param unknown_type $arguments
   * @param unknown_type $options
   * @todo run in build task
   * @todo add lock file
   */
  protected function execute($arguments = array(), $options = array()) {
    // run only in staging or dev mode
    if ($options['env'] != "prod" && $options['env'] != "staging") {
      throw new sfException(sprintf("Don't run the s3sync in the '%s' environment.", $options['env']));
    }

    $lReleaseName = sfConfig::get('app_release_name');
    $lRootDir = sfContext::getInstance()->getConfiguration()->getRootDir();
    $lFileName = CdnSingleton::getInstance()->getNextHost() .'/'. $lReleaseName."/";

    $lFiles = FilesystemHelper::retrieveFilesInDir($lRootDir.'/web/css/include', array('.svn'), array(), '.css');

    $this->logSection('\r\n\r\n');
    $this->logSection('#####################################################################');
    $this->logSection('############ this skript will change image paths in your local css files');
    $this->logSection('############ you must not commit those changes, it\'ll fuck up pathes!!!');
    $this->logSection('#####################################################################');
    $this->logSection('############ best executed on dev/live where nothing gets comittet to svn ;)');
    $this->logSection('#####################################################################');
    $this->logSection('\r\n\r\n');

    foreach ($lFiles as $lFile) {
      $lContent = file_get_contents($lFile);
      $lContent = str_replace('url("/img/', 'url("'.$lFileName."img/", $lContent);

      $fp = fopen($lFile, 'w');
      fwrite($fp, $lContent);
      fclose($fp);
    }

    if ($options['env'] == "prod") {
      $lBucket = "live.yiidcdn.com";
    } else {
      $lBucket = "dev.yiidcdn.com";
    }

    sfFileSystem::execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/css/ s3://$lBucket/$lReleaseName/css/");
    sfFileSystem::execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/img/ s3://$lBucket/$lReleaseName/img/");
    sfFileSystem::execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/js/100_main/include/ s3://$lBucket/$lReleaseName/js/100_main/include/");

    sfFileSystem::execute("find ./web/js/100_main/include -type f -exec 7z a -tgzip -x\!\*.svn -x\!\*.gz  {}.gz {} \;");
    sfFileSystem::execute("s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'application/javascript' --add-header 'Content-Encoding: gzip' sync web/js/100_main/include/ s3://$lBucket/$lReleaseName/js/100_main/include/");
    sfFileSystem::execute("find ./web/js/100_main/include -name '*.gz' -exec rm {} \;");

    sfFileSystem::execute("find ./web/css -type f -exec 7z a -tgzip  -x\!\*.svn -x\!\*.gz  {}.gz {} \;");
    sfFileSystem::execute("s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'text/css' --add-header 'Content-Encoding: gzip' sync web/css/ s3://$lBucket/$lReleaseName/css/");
    sfFileSystem::execute("find ./web/css -name '*.gz' -exec rm {} \;");
  }
}
