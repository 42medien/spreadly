<?php
class DealListener {

  public static function eventSubmit($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventSubmit");
    $deal = $event->getSubject();
    $sender = array(sfConfig::get("app_email_address") => sfConfig::get("app_email_sender"));
    
    $admins = sfGuardUserTable::getInstance()->findByIsSuperAdmin(true);
    foreach ($admins as $admin) {
      sfContext::getInstance()->getLogger()->notice("{DealListener} Sending email to admin: ".$admin->getEmailAddress());
      try {
        sfContext::getInstance()->getMailer()->composeAndSend($sender, $admin->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getSummary()), sfConfig::get("app_settings_url").'/backend.php/deal/'.$deal->getId().'/edit' );        
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());        
      }
    }

    sfContext::getInstance()->getLogger()->notice("{DealListener} Sending email to deal owner: ".$deal->getSfGuardUser()->getEmailAddress());
    
    try {
      $message = "".
      "Ihr Deal ist in unserem System eingegangen und wird in Kürze von einem Mitarbeiter bearbeitet.\n\n".
      "Your Deal has been submitted to our system. It will be reviewed by an employee shortly.";
      
      sfContext::getInstance()->getMailer()->composeAndSend($sender, $deal->getSfGuardUser()->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getSummary()), $message);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());        
    }
    

  }

  public static function eventApprove($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventApprove");
  }

  public static function eventDeny($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventDeny");
  }

}
