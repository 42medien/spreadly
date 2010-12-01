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
  
  public static function updateMongoDeal($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();

    $db = new Mongo(sfConfig::get('app_mongodb_host'));
    $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name'), "deals");
    
    if($deal->getState()=='approved') {
      $col->update(array("id" => $deal->getId()), $deal->toMongoArray(), array("upsert" => true));
    } else {
      $col->remove(array("id" => $deal->getId()));
    }
  }
}
