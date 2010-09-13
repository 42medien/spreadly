<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../../lib/vendor/OpenGraph/OpenGraph.php');
require_once(dirname(__FILE__).'/../../lib/utils/parser/SocialObjectParser.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);
sfContext::createInstance($configuration);
$logger = sfContext::getInstance()->getLogger();
// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();

//SocialObjectParser::fetch("http://pfefferle.org");

$lSocialObject = new SocialObject();
$lSocialObject->setUrl('http://notizblog.org');

$lObject = $lSocialObject->save();

?>