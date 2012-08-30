<?php
/**
 * Wrap some basic methods for SQS
 *
 * @author Christian Weyand
 * @author Matthias Pfefferle
 */
class AmazonSQSUtils {
  public static function initSqsService() {
    return new SQS(sfConfig::get('app_amazons3_access_key'), sfConfig::get('app_amazons3_secret_key'));
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
    $pQueueName = $pQueueName."-".sfConfig::get('sf_environment');

    $service = self::initSqsService();
    $service->createQueue($pQueueName);

    if (is_array($pPayload)) {
      foreach ($pPayload as $value) {
        $service->sendMessage($pQueueName, $value);
        sfContext::getInstance()->getLogger()->info("{AmazonSQSUtils} ".$pQueueName." sent ". print_r($value, true));
      }
    }
    else {
      $service->sendMessage($pQueueName, $pPayload);
      sfContext::getInstance()->getLogger()->info("{AmazonSQSUtils} ".$pQueueName." sent ". print_r($pPayload, true));
    }
  }
}