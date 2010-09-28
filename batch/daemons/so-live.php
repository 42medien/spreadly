#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/../../lib/utils/YiidDaemon.php');
require_once(dirname(__FILE__).'/../../lib/utils/parser/SocialObjectParser.php');

$lAppName = "so-live";
$lQueueName = "SocialObjectParser";

// Setup
$lOptions = array(
    'appName' => $lAppName,
    'appDir' => dirname(__FILE__),
    'appDescription' => $lAppName,
    'authorName' => 'Matthias Pfefferle',
    'authorEmail' => 'matthias@ekaabo.de',
    'sysMaxExecutionTime' => '0',
    'sysMaxInputTime' => '0',
    'sysMemoryLimit' => '64M',
    'appRunAsGID' => 0,
    'appRunAsUID' => 0,
);

YiidDaemon::run($lQueueName, $argv, "SocialObjectParser", "enrich", $lOptions);
?>