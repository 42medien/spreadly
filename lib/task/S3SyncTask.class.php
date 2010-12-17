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
      new sfCommandOption('application', null, sfCommandOption::PARAMETER_REQUIRED, 'The application name', 'platform'),
      new sfCommandOption('env', null, sfCommandOption::PARAMETER_REQUIRED, 'The environment', 'dev'),
      new sfCommandOption('connection', null, sfCommandOption::PARAMETER_REQUIRED, 'The connection name', 'doctrine'),
      // add your own options here
    ));

    $this->namespace        = 'yiid';
    $this->name             = 's3-sync';
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
    if ($options['env'] == "dev") {
      throw new sfException(sprintf("Don't run the s3sync in the '%s' environment.", $options['env']));
    }

    $lReleaseName = sfConfig::get('app_release_name');
    $lBucket = sfConfig::get('app_amazons3_bucket');
    $lNewPath = CdnSingleton::getInstance()->getNextHost() .'/'. $lReleaseName;

    $lCssDirectory = sfConfig::get('sf_web_dir')."/css";
    $lS3Directory = sfConfig::get('sf_web_dir')."/s3sync";

    $this->getFilesystem()->execute("rm -rf ".$lS3Directory."/css");
    $this->getFilesystem()->execute("rsync -aC --exclude .svn ".$lCssDirectory." ".$lS3Directory);

    $lFiles = sfFinder::type('file')->follow_link()->relative()->in($lS3Directory."/css");

    foreach ($lFiles as $lFile) {
      // absolute path
      $lFile = $lS3Directory."/css/".$lFile;

      $lContent = file_get_contents($lFile);
      $lContent = str_replace('url("/img/', 'url("'.$lNewPath."/img/", $lContent);

      $fp = fopen($lFile, 'w');
      fwrite($fp, $lContent);
      fclose($fp);
    }

    $this->getFilesystem()->execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/s3sync/css/ s3://$lBucket/$lReleaseName/css/");
    $this->getFilesystem()->execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/img/ s3://$lBucket/$lReleaseName/img/");
    $this->getFilesystem()->execute("s3cmd --bucket-location=EU -P -r --exclude='*.svn*' --add-header 'Expires: Sat, 08 May 2015 15:22:28 GMT' sync web/js/100_main/include/ s3://$lBucket/$lReleaseName/js/100_main/include/");

    $this->getFilesystem()->execute("find ./web/js/100_main/include -type f -exec 7z a -tgzip -x\!\*.svn -x\!\*.gz  {}.gz {} \;");
    $this->getFilesystem()->execute("s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'application/javascript' --add-header 'Content-Encoding: gzip' sync web/js/100_main/include/ s3://$lBucket/$lReleaseName/js/100_main/include/");
    $this->getFilesystem()->execute("find ./web/js/100_main/include -name '*.gz' -exec rm {} \;");

    $this->getFilesystem()->execute("find ./web/css -type f -exec 7z a -tgzip  -x\!\*.svn -x\!\*.gz  {}.gz {} \;");
    $this->getFilesystem()->execute("s3cmd --bucket-location=EU -P -r --exclude='*.*' --include '*.gz' --mime-type 'text/css' --add-header 'Content-Encoding: gzip' sync web/css/ s3://$lBucket/$lReleaseName/css/");
    $this->getFilesystem()->execute("find ./web/css -name '*.gz' -exec rm {} \;");
  }
}