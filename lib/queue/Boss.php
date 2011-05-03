#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/Worker.php');

Spreadly\Worker::work($argv);