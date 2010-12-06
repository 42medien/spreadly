<?php
class DealListener {
  
  public static function eventSubmit($event) {
    $deal = $event->getSubject();

    $admins = sfGuardUserTable::getInstance()->findByIsSuperAdmin(true);
    foreach ($admins as $admin) {
      sfContext::getInstance()->getMailer()->composeAndSend('deals@ekaabo.com', $admin->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getSummary()), sfConfig::get("app_settings_url").'/backend.php/deal/'.$deal->getId().'/edit' );
    }
  }

  public static function eventApprove($event) {
  }

  public static function eventDeny($event) {
  }

  public static function eventPause($event) {
  }

  public static function eventResume($event) {
  }

  public static function eventTrash($event) {
  }
  
  public static function updateMongoDeal($event) {
    $deal = $event->getSubject();
    $params = $event->getParameters();

    $db = new Mongo(sfConfig::get('app_mongodb_host'));
    $col = $db->selectCollection(sfConfig::get('app_mongodb_database_name'), "deals");

    if($deal->getState()=='approved') {
      $col->update(array("id" => intval($deal->getId())), $deal->toMongoArray(), array("upsert" => true));
    } else {
      $col->remove(array("id" => intval($deal->getId())));
    }
  }
}
