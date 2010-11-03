<?php
/**
 * track stats
 *
 * @author Matthias Pfefferle
 */
class StatsFeeder {
  /**
   * track full stats
   *
   * @author Matthias Pfefferle
   * @param sfEvent $event
   */
  public static function track(sfEvent $pEvent) {
    sfContext::getInstance()->getLogger()->err("{StatsFeeder} " . print_r($pEvent, true));

    //error_log(print_r($pEvent, true) . "\n", 3, dirname(__FILE__).'/event.log');
  }
}