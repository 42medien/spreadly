<?php
class DealListener {

  public static function eventSubmit($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventSubmit");
    $deal = $event->getSubject();

    $admins = sfGuardUserTable::getInstance()->findByIsSuperAdmin(true);
    foreach ($admins as $admin) {
      sfContext::getInstance()->getLogger()->notice("{DealListener} Sending email to ".$admin->getEmailAddress());
      try {
        sfContext::getInstance()->getMailer()->composeAndSend('deals@ekaabo.com', $admin->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getSummary()), sfConfig::get("app_settings_url").'/backend.php/deal/'.$deal->getId().'/edit' );        
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());        
      }
    }
  }

  public static function eventApprove($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventApprove");
  }

  public static function eventDeny($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventDeny");
  }

  public static function eventPause($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventPause");
  }

  public static function eventResume($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventResume");
  }

  public static function eventTrash($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventTrash");
  }

  public static function updateMongoDeal($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} updateMongoDeal");
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
