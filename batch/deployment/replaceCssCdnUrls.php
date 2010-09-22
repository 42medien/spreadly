<?php

/**
 * This script fetches the I18N db from the live system and inserts it in the
 * lokal db (must be communipedia_dev, yiid_ci, yiid_selenium)
 */

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../../lib/utils/FilesystemHelper.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'widget', true);
sfContext::createInstance($configuration);




$lRootDir = sfContext::getInstance()->getConfiguration()->getRootDir();
$lFileName = CdnSingleton::getInstance()->getNextHost() .'/'. sfConfig::get('app_release_name')."/";


$lFiles = FilesystemHelper::retrieveFilesInDir($lRootDir.'/web/css/include', array('.svn', 'include'), array(), '.css');



foreach ($lFiles as $lFile) {
  $lContent = file_get_contents($lFile);
  $lContent = str_replace('url("/img/', 'url("'.$lFileName."img/", $lContent);

  $fp = fopen($lFile, 'w');
  fwrite($fp, $lContent);
  fclose($fp);
}
