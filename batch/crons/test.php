<?php
/**
 * a batch file to send an email if a deal is expired
 *
 * @author Matthias Pfefferle
 */
require_once(dirname(__FILE__).'/../../config/BatchConfiguration.class.php');
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = \ProjectConfiguration::getApplicationConfiguration('statistics', BatchConfiguration::ENV, true);
\sfContext::createInstance($configuration);

// get job
$job = Queue\Queue::getInstance()->get();

if ($job) {
  try {
    // try to execute job
    $job->execute();
    $job->finished();
  } catch (\Exception $e) {
    $job->reschedule($e->getMessage());
  }
}
?>