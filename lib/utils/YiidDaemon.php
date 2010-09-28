<?php
// Include Class
error_reporting(E_ALL);
require_once 'System/Daemon.php';
require_once(dirname(__FILE__).'/../vendor/sqs.php');
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * the yiid daemon class
 *
 * @author Christian Weyand
 * @author Matthias Pfefferle
 * @since rogue
 * @link http://kevin.vanzonneveld.net/techblog/article/create_daemons_in_php/
 */
class YiidDaemon {
  /**
   * the amazon access-key
   * @var string
   */
  public static $aAmazonKey    = 'AKIAJ5NSA6ET5RC4AMXQ';
  /**
   * the amazon secret key
   * @var string
   */
  public static $aAmazonSecret = 'bs1YgS4c1zJN/HmwaVA8CkhNfyvcS+EEm1hcEOa0';
  /**
   * the default options
   * @var array
   */
  public  static $aOptions = array(
                      'appName' => 'YiidDaemon',
                      'appDir' => '/',
                      'appDescription' => 'the default daemon',
                      'authorName' => 'ekaabo',
                      'authorEmail' => 'info@ekaabo.de',
                      'sysMaxExecutionTime' => '0',
                      'sysMaxInputTime' => '0',
                      'sysMemoryLimit' => '64M',
                      'appRunAsGID' => 0,
                      'appRunAsUID' => 0,
  ); // default options
  /**
  * run the daemon
  *
  * @author Matthias Pfefferle
  * @param string $pQueueName the name of the Queue
  * @param array $pArguments the console arguments ($argv)
  * @param string $pClass the class-name (for the callback)
  * @param string $pFunction the function-name (for the callback)
  * @param array $pOptions optional options array
  */
  public static function run($pQueueName, $pArguments, $pClass, $pFunction, $pOptions = null) {
    // if $pOptions is empty take the default params
    if (!$pOptions) {
      $pOptions = self::$aOptions;
    }

    // Allowed arguments & their defaults
    $runmode = array(
      'no-daemon' => false,
      'help' => false,
      'write-initd' => true,
    );

    $argv = $pArguments;

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

    System_Daemon::setOptions($pOptions);

    // This program can also be run in the forground with runmode --no-daemon
    if (!$runmode['no-daemon']) {
      // Spawn Daemon
      System_Daemon::start();
    }

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

    $lMessageBroker = new SQS(self::$aAmazonKey, self::$aAmazonSecret);
    // creates queue if not exists
    $lMessageBroker->createQueue($pQueueName);
    while (!System_Daemon::isDying() && $runningOkay ) {
      // What mode are we in?
      $mode = '"'.(System_Daemon::isInBackground() ? '' : 'non-' ).'daemon" mode';

      // Log something using the Daemon class's logging facility
      // Depending on runmode it will either end up:
      //  - In the /var/log/logparser.log
      //  - On screen (in case we're not a daemon yet)
      System_Daemon::info('{appName} running in %s %s', $mode, $cnt);

      $message = $lMessageBroker->receiveMessage($pQueueName, 1);

      if (!empty($message)) {
        if (sfConfig::get('settings_dev')) {
          System_Daemon::info('{appName} received message with id %s %s', $message[0]['MessageId'], urldecode($message[0]['Body']));
        }
        // run the importer
        call_user_func(array($pClass, $pFunction), $message);
      }
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

      // Relax the system by sleeping for a little bit
      // iterate also clears statcache
      System_Daemon::iterate(1);
      if (!empty($message)) {
        $lMessageBroker->deleteMessage($pQueueName, $message[0]['ReceiptHandle']);
      }
      $cnt++;
    }

    // Shut down the daemon nicely
    // This is ignored if the class is actually running in the foreground
    System_Daemon::stop();
  }
}