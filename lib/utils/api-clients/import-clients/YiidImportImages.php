<?php
// required because its called like a batch outside of the symfony context
require_once(dirname(__FILE__).'/../../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', false);
sfContext::createInstance($configuration);

/**
 * class to import the contacts from an online identity
 *
 * @author weyandch
 */
class YiidImportImages {
  public static function import($pMessage) {
    $lPayload = unserialize($pMessage[0]['Body']);
    sfContext::getInstance()->getLogger()->debug("{Daemon} ImportImages with payload : ". print_r($lPayload, 1) );

    // set variables we need
    $lOnlineIdentity = OnlineIdentityTable::getInstance()->retrieveByPk($lPayload['oi_id']);
    $lUserId = $lPayload['user_id'];
    $lImgPath = $lPayload['path'];

    if ($lOnlineIdentity) {
      try {
        ImageImporter::importByUrlAndUserId($lImgPath, $lUserId, $lOnlineIdentity);
      }
      catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{Daemon} ImportImages  : ".print_r($e, true) );
      }
    }
  }
}