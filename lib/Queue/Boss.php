#!/usr/bin/php -q
<?php
error_reporting(0);
require_once(dirname(__FILE__).'/Worker.php');

Queue\Worker::work($argv);