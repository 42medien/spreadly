<?php
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
sfContext::createInstance($configuration);


$lUserHugo = UserTable::retrieveByUsername('hugo');
$lUserHans = UserTable::retrieveByUsername('hans');





?>