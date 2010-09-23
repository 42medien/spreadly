#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/../../lib/utils/YiidDaemon.php');
require_once(dirname(__FILE__).'/../../lib/utils/api-clients/import-clients/YiidImportContacts.php');

$lAppName = "contacts";
$lQueueName = "ImportContacts";

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

YiidDaemon::run($lQueueName, $argv, "YiidImportContacts", "import", $lOptions);
?>