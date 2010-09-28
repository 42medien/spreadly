<?php
require_once(dirname(__FILE__).'/../vendor/sqs.php');
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * Enter description here...
 *
 * @author Christian Weyand
 * @author Matthias Pfefferle
 */
class AmazonSQSUtils {
  public static function initSqsService() {
    return new SQS(YiidDaemon::$aAmazonKey,YiidDaemon::$aAmazonSecret);
  }

  /**
   * push a given payload (mostly object Id) to an amazon queue
   *
   * @param string $pQueueName
   * @param string $pPayload
   * @author Christian Weyand
   * @author Matthias Pfefferle
   */
  public static function pushToQuque($pQueueName, $pPayload) {
    // add environment for a better cue handling
    if (sfConfig::get('app_settings_dev')) {
      $pQueueName = $pQueueName."-".sfConfig::get('app_settings_environment');
    }

    $service = self::initSqsService();
    if (is_array($pPayload)) {
      foreach ($pPayload as $value) {
        $service->sendMessage($pQueueName, $value);
      }
    }
    else {
      $service->sendMessage($pQueueName, $pPayload);
    }
  }

}
?>