<?php
require_once(dirname(__FILE__).'/../vendor/sqs.php');


class AmazonSQSUtils {


  public static function initSqsService() {
    return new SQS(YiidDaemon::$aAmazonKey,YiidDaemon::$aAmazonSecret);
  }

  /**
   * push a given payload (mostly object Id) to an amazon queue
   *
   * @param string $pQueueName
   * @param string $pPayload
   */
  public static function pushToQuque($pQueueName, $pPayload) {
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