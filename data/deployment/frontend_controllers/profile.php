<?php


require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('profile', 'local', false);
sfContext::createInstance($configuration)->dispatch();
