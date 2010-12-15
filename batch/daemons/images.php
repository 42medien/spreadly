#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/../../lib/utils/YiidDaemon.php');

$lAppName = "images";
$lQueueName = "ImageImport";

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
    'appRunAsGID' => 1001,
    'appRunAsUID' => 1001,
);

YiidDaemon::run($lQueueName, $argv, "YiidImportImages", "import", $lOptions);
?>