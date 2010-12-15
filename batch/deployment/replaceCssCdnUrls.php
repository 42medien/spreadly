<?php

/**
 * This script fetches the I18N db from the live system and inserts it in the
 * lokal db (must be communipedia_dev, yiid_ci, yiid_selenium)
 */

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../../lib/utils/FilesystemHelper.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'staging', true);
sfContext::createInstance($configuration);




$lRootDir = sfContext::getInstance()->getConfiguration()->getRootDir();
$lFileName = CdnSingleton::getInstance()->getNextHost() .'/'. sfConfig::get('app_release_name')."/";


$lFiles = FilesystemHelper::retrieveFilesInDir($lRootDir.'/web/css/include', array('.svn'), array(), '.css');

echo "\r\n\r\n";
echo "#####################################################################";
echo "############ this skript will change image paths in your local css files";
echo "############ you must not commit those changes, it'll fuck up pathes!!!";
echo "#####################################################################";
echo "############ best executed on dev/live where nothing gets comittet to svn ;)";
echo "#####################################################################";
echo "\r\n\r\n";




foreach ($lFiles as $lFile) {
  $lContent = file_get_contents($lFile);
  $lContent = str_replace('url("/img/', 'url("'.$lFileName."img/", $lContent);

  $fp = fopen($lFile, 'w');
  fwrite($fp, $lContent);
  fclose($fp);
}
