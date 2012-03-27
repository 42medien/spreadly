<?php
/**
 * class to import twitter contacts
 *
 * @author Matthias Pfefferle
 * @author Karina Mies
 */
class LinkedinImportClient {
  /**
   * import twitter contacts
   *
   * @author Matthias Pfefferle
   * @author Karina Mies
   */
  public static function importContacts($pOnlineIdentity) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    // get api informations
    if (!$lToken) {
      $pOnlineIdentity->deactivate();
      throw new Exception('damn theres no token!', '666');
    }
    $lConsumer = new OAuthConsumer(sfConfig::get("app_linkedin_oauth_token"), sfConfig::get("app_linkedin_oauth_secret"));
    $lXml = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.linkedin.com/v1/people/~/connections:(id)");

    $lFriendObject = simplexml_load_string($lXml);

    $lXml = OAuthClient::get($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "http://api.linkedin.com/v1/people/~:(id,site-standard-profile-request,summary,picture-url,first-name,last-name,date-of-birth,location)");
    $lProfileArray = XmlUtils::XML2Array($lXml);

    self::importFriends($pOnlineIdentity, $lFriendObject);
    self::updateIdentity($pOnlineIdentity, $lProfileArray);
  }


  /**
   * gather list of friends from linknedin
   *
   * @param $pOnlineIdentity
   * @param $lToken
   * @return unknown_type
   */
  public static function importFriends(&$pOnlineIdentity, $lFriendObject) {
    $lArray = array();

    foreach ($lFriendObject->person as $lPerson) {
      $lArray[] = "'".$lPerson->id."'";
    }

    $pOnlineIdentity->setFriendIds(implode(",", $lArray));
    $pOnlineIdentity->setFriendCount(count($lArray));
    $pOnlineIdentity->save();
  }


  /**
   * update the given online identity with latest data from linkedin
   *
   * @param $pOnlineIdentity
   * @param $lToken
   * @return unknown_type
   */
  public static function updateIdentity(&$pOnlineIdentity, $pProfileArray) {

    if (isset($pProfileArray['date-of-birth']['year'])) {
      $pOnlineIdentity->setBirthdate($pProfileArray['date-of-birth']['year'].'-'.$pProfileArray['date-of-birth']['month'].'-'.$pProfileArray['date-of-birth']['day']);
    }
    $pOnlineIdentity->setLocationRaw($pProfileArray['location']['name']);
    $pOnlineIdentity->save();

    $lUser = $pOnlineIdentity->getUser();
    // update user's birthdate if it's not set yet and provided by this identity
    if (is_null($lUser->getBirthdate()) && $pOnlineIdentity->getBirthdate()) {
      $lUser->setBirthdate($pOnlineIdentity->getBirthdate());
      $lUser->save();
    }
  }

}