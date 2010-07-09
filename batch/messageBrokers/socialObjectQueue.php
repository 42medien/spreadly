#!/usr/bin/php -q
<?php
require_once 'System/Daemon.php';
require_once(dirname(__FILE__).'/../../lib/vendor/sqs.php');


// Allowed arguments & their defaults
$runmode = array(
    'no-daemon' => false,
    'help' => false,
    'write-initd' => true,
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

// Setup
$options = array(
    'appName' => 'yiid-socialObjectBroker',
    'appDir' => dirname(__FILE__),
    'appDescription' => 'MessageBroker for SocialObjects',
    'authorName' => 'Christian Weyand',
    'authorEmail' => 'christian.weyand@ekaabo.de',
    'sysMaxExecutionTime' => '0',
    'sysMaxInputTime' => '0',
    'sysMemoryLimit' => '64M',
    'appRunAsGID' => 0,
    'appRunAsUID' => 0,
);

System_Daemon::setOptions($options);

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
    System_Daemon::info(
            'sucessfully written startup script: %s',
    $initd_location
    );
  }
}

// Run your code
// Here comes your own actual code

// This variable gives your own code the ability to breakdown the daemon:
$runningOkay = true;

// This variable keeps track of how many 'runs' or 'loops' your daemon has
// done so far. For example purposes, we're quitting on 3.
$cnt = 1;
$queue = 'testerle1';

$lQueue = new SQS($key, $secret);
// While checks on 3 things in this case:
// - That the Daemon Class hasn't reported it's dying
// - That your own code has been running Okay
// - That we're not executing more than 3 runs
while (!System_Daemon::isDying() && $runningOkay ) {
  // What mode are we in?
  $mode = '"'.(System_Daemon::isInBackground() ? '' : 'non-' ).
        'daemon" mode';

  // Log something using the Daemon class's logging facility
  // Depending on runmode it will either end up:
  //  - In the /var/log/logparser.log
  //  - On screen (in case we're not a daemon yet)
  System_Daemon::info('{appName} running in %s %s',
  $mode,
  $cnt
  );

  $message = $lQueue->receiveMessage($queue, 1);

  System_Daemon::info('{appName} received message with id %s %s', $message[0]['MessageId'], urldecode($message[0]['Body']));
  if (!empty($message)) {
    $lQueue->deleteMessage($queue, $message[0]['ReceiptHandle']);
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
    System_Daemon::err('parseLog() produced an error, '.
            'so this will be my last run');
  }

  // Relax the system by sleeping for a little bit
  // iterate also clears statcache
 // System_Daemon::iterate(1);

  $cnt++;
}

// Shut down the daemon nicely
// This is ignored if the class is actually running in the foreground
System_Daemon::stop();