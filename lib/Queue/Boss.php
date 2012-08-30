#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/Worker.php');
error_reporting(0);

Queue\Worker::work($argv);