<?php
class DealListener {
  
  public static function eventSubmit($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }

  public static function eventApprove($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }

  public static function eventDeny($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }

  public static function eventPause($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }

  public static function eventResume($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }

  public static function eventTrash($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();
  }
}

  
