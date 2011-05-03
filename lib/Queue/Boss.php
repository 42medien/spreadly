#!/usr/bin/php -q
<?php
require_once(dirname(__FILE__).'/Worker.php');

Queue\Worker::work($argv);