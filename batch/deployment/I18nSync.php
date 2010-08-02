<?php

/**
 * This script fetches the I18N db from the live system and inserts it in the
 * lokal db (must be communipedia_dev, yiid_ci, yiid_selenium)
 */


require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

$pTranslatorDb = $dbManager->getDatabase('translation');
$pTranslatorDbArray = $pTranslatorDb->getParameterHolder()->getAll();


$lDsnItems = explode(';', $pTranslatorDbArray['dsn']);
$lDBNameArr = explode('=', stristr($lDsnItems[1], 'dbname='));
$lDBName = $lDBNameArr[1];
$lHostNameArr = explode('=', stristr($lDsnItems[0], 'host='));
$lHostName = $lHostNameArr[1];

system('wget http://www.yiid.local/test.sql');
system('mysql -u ' . $pTranslatorDbArray['username'] . ' -h ' . $lHostName . ' -p' . $pTranslatorDbArray['password'] . ' ' . $lDBName . ' < test.sql');


?>
