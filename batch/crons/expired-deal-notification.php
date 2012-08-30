<?php
/**
 * a batch file to send an email if a deal is expired
 *
 * @author Matthias Pfefferle
 */
require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('statistics', 'dev', false);
sfContext::createInstance($configuration);

$dm = MongoManager::getDM();

$logger = sfContext::getInstance()->getLogger();

$deals = DealTable::getInstance()->getExpiredDealsByExpirationDate();

$message = null;
foreach($deals as $deal) {
  $message .= "http://spreadly.com/backend.php/deal/".$deal->getId()."/edit \n";
}

if ($message) {
  sfContext::getInstance()->getMailer()->composeAndSend($sender = array(sfConfig::get("app_email_address") => sfConfig::get("app_email_sender")), sfConfig::get("app_settings_support_email"), '[expired deals]', $message);
}
?>