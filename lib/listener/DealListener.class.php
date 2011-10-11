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
        sfContext::getInstance()->getMailer()->composeAndSend($sender, $admin->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getName()), sfConfig::get("app_settings_url").'/backend.php/deal/'.$deal->getId().'/edit' );
      } catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());
      }
    }

    sfContext::getInstance()->getLogger()->notice("{DealListener} Sending email to deal owner: ".$deal->getSfGuardUser()->getEmailAddress());

    try {
      $fullname = $deal->getSfGuardUser()->getProfile()->getFullname();
      $message = "".
      "Hallo $fullname,

Ihr Deal ist bei Spread.ly eingegangen und wird in Kürze von einem Mitarbeiter bearbeitet. Sie erhalten so schnell wie möglich ein Mail mit der Freigabe.

Your Deal has been submitted to Spread.ly. It will be reviewed by an employee shortly. You will receive an email with our approval as soon as possible.

Viele Grüße & many regards 
Spread.ly-Team

info@spreadly.com
ekaabo GmbH
Grundelbachstr. 84
D-69469 Weinheim
tel: +49 6201 845200
fax: +49 6201 84520-29
www.ekaabo.de
Amtsgericht Mannheim / HRB 701542
Geschäftsführer: Marco Ripanti
Get your button & Spread your likes –www.Spreadly.com
Weblog – Blog.spreadly.com
";

      sfContext::getInstance()->getMailer()->composeAndSend($sender, $deal->getSfGuardUser()->getEmailAddress(), '[Deal submitted]: '.preg_replace('/\n/', '', $deal->getName()), $message);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());
    }


  }

  public static function eventApprove($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventApprove");
    $deal = $event->getSubject();
    $sender = array(sfConfig::get("app_email_address") => sfConfig::get("app_email_sender"));

    sfContext::getInstance()->getLogger()->notice("{DealListener} Sending email to deal owner: ".$deal->getSfGuardUser()->getEmailAddress());

    try {
      $fullname = $deal->getSfGuardUser()->getProfile()->getFullname();
      $message = "".
      "Hallo $fullname,

Ihr Deal wurde soeben frei geschaltet. Sobald die Laufzeit begonnen hat, kann der Deal von Besuchern eingelöst werden.

Your deal is available now. Provided that runtime has become due your deal can be redeemed. 

Viel Erfolg beim Handel mit den Likes & Good luck and success with your deals in likes! Spread.ly-Team


info@spreadly.com
ekaabo GmbH
Grundelbachstr. 84
D-69469 Weinheim
tel: +49 6201 845200
fax: +49 6201 84520-29
www.ekaabo.de
Amtsgericht Mannheim / HRB 701542
Geschäftsführer: Marco Ripanti
Get your button & Spread your likes –www.Spreadly.com
Weblog – Blog.spreadly.com
";

      sfContext::getInstance()->getMailer()->composeAndSend($sender, $deal->getSfGuardUser()->getEmailAddress(), '[Deal ready]: '.preg_replace('/\n/', '', $deal->getName()), $message);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());
    }
  }

  public static function eventDeny($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventDeny");
  }

  public static function eventExpire($event) {
    sfContext::getInstance()->getLogger()->notice("{DealListener} eventExpire");

    $deal = $event->getSubject();

    $sender = array(sfConfig::get("app_email_address") => sfConfig::get("app_email_sender"));

    try {
      $message = "Dear Advertiser,\n\n
                  we are happy to inform you, that your campaign was successfully delivered.\n
                  If you like to know more about the people who taken part in your campaign, please take a look into you backend on http://www.spreadly.com/\n\n
                  Thanks a lot and many regards\n
                  Your Spreadly-Team.";

      sfContext::getInstance()->getMailer()->composeAndSend($sender, $deal->getSfGuardUser()->getEmailAddress(), '[Deal expired]: '.preg_replace('/\n/', '', $deal->getName()), $message);
    } catch (Exception $e) {
      sfContext::getInstance()->getLogger()->err("{DealListener} Failed to send email.\n".$e->getMessage());
    }
  }
}
