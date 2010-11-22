<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('engineroom', 'local', false);
sfContext::createInstance($configuration)->dispatch();
