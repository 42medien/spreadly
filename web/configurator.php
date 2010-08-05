<?php

require_once(dirname(__FILE__).'/../config/ProjectConfiguration.class.php');
$configuration = ProjectConfiguration::getApplicationConfiguration('configurator', 'prod', false);
include_once(dirname(__FILE__).'/../config/setIncludePath.php');
sfContext::createInstance($configuration)->dispatch();