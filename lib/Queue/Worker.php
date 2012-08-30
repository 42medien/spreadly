<?php
namespace Queue;

use \sfException,
    \Exception,
    \sfContext,
    \System_Daemon,
    \BatchConfiguration,
    \ProjectConfiguration,
    \AmazonCloudWatch;

require_once 'System/Daemon.php';
require_once(dirname(__FILE__).'/../../config/BatchConfiguration.class.php');
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', BatchConfiguration::ENV, true);
sfContext::createInstance($configuration);


/**
 * Worker
 *
 * @author Hannes Schippmann
 * @author Matthias Pfefferle
 */
class Worker {
  public static function work($argv = array()) {
    $appName = 'Worker';
    if (BatchConfiguration::ENV != "prod") {
      $appName = 'Worker-'.BatchConfiguration::ENV;
    }

    $options = array('appName' => $appName,
                     'appDir' => dirname(__FILE__),
                     'appDescription' => 'spreadlys brave worker',
                     'authorName' => 'ekaabo',
                     'authorEmail' => 'info@ekaabo.de',
                     'sysMaxExecutionTime' => '0',
                     'sysMaxInputTime' => '0',
                     'sysMemoryLimit' => '64M',
                     'appRunAsGID' => 1001,
                     'appRunAsUID' => 1001);

    // Allowed arguments & their defaults
    $runmode = array(
      'no-daemon' => false,
      'help' => false,
      'write-initd' => false
    );

    // Scan command line attributes for allowed arguments
    foreach ($argv as $k=>$arg) {
      if (substr($arg, 0, 2) == '--' && isset($runmode[substr($arg, 2)])) {
        $runmode[substr($arg, 2)] = true;
      }
    }

    // Help mode. Shows allowed argumentents and quit directly
    if ($runmode['help'] == true) {
      echo 'Usage: '.$argv[0].' [runmode]' . "\n";
      echo 'Available runmodes:' . "\n";
      foreach ($runmode as $runmod=>$val) {
        echo ' --'.$runmod . "\n";
      }
      die();
    }

    System_Daemon::setOptions($options);

    // This program can also be run in the forground with runmode --no-daemon
    if (!$runmode['no-daemon']) {
      // Spawn Daemon
      System_Daemon::start();
    }

    System_Daemon::info('============================');
    System_Daemon::info('daemon started');
    System_Daemon::info('============================');

    // With the runmode --write-initd, this program can automatically write a
    // system startup file called: 'init.d'
    // This will make sure your daemon will be started on reboot
    if (!$runmode['write-initd']) {
      System_Daemon::info('not writing an init.d script this time');
    } else {
      if (($initd_location = System_Daemon::writeAutoRun()) === false) {
        System_Daemon::notice('unable to write init.d script');
      } else {
        System_Daemon::info('sucessfully written startup script: %s', $initd_location);
      }
    }

    // This variable gives your own code the ability to breakdown the daemon:
    $runningOkay = true;

    // This variable keeps track of how many 'runs' or 'loops' your daemon has
    // done so far. For example purposes, we're quitting on 3.
    $cnt = 1;

    while (!System_Daemon::isDying() && $runningOkay ) {
      // What mode are we in?
      $mode = '"'.(System_Daemon::isInBackground() ? '' : 'non-' ).'daemon" mode';

      // get job
      $job = Queue::getInstance()->get();

      if ($job) {
        try {
          // try to execute job
          $job->execute();
          $job->finished();

          System_Daemon::info('{appName} finished job %s of type %s', $cnt, get_class($job));
        } catch (Exception $e) {
          $job->reschedule($e->getMessage());

          System_Daemon::err('{appName} resceduled job %s of type %s because of "%s"', $cnt, get_class($job), $e->getMessage());
        }

        // get next job immediately
        System_Daemon::iterate(0);
      } else {
        // idle a bit
        System_Daemon::iterate(1);
      }

      $cw = new AmazonCloudWatch();
      $cw->set_region(AmazonCloudWatch::REGION_EU_W1);

      $cw->put_metric_data("Spreadly/".BatchConfiguration::ENV, array(array("MetricName" => "WorkerAliveCheck", "Unit" => "Bits", "Value" => 1)));

      // In the actuall logparser program, You could replace 'true'
      // With e.g. a  parseLog('vsftpd') function, and have it return
      // either true on success, or false on failure.
      $runningOkay = true;
      //$runningOkay = parseLog('vsftpd');
      // Should your parseLog('vsftpd') return false, then
      // the daemon is automatically shut down.
      // An extra log entry would be nice, we're using level 3,
      // which is critical.
      // Level 4 would be fatal and shuts down the daemon immediately,
      // which in this case is handled by the while condition.
      if (!$runningOkay) {
        System_Daemon::err('parseLog() produced an error, so this will be my last run');
      }

      $cnt++;
    }

    // Shut down the daemon nicely
    // This is ignored if the class is actually running in the foreground
    System_Daemon::stop();
  }
}