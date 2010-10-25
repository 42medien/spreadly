<?php
/**
 * Api to post google buzz status messages
 *
 * @author Matthias Pfefferle
 */
class GooglePostApiClient extends PostApi {

  /**
   * defines the post function
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param string $pUrl if the url is not part of the message
   * @param string $pType
   * @param string $pScore
   * @return int status code
   */
  public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle = null, $pDescription = null, $pPhoto = null) {
    $lToken = AuthTokenTable::getByUserAndOnlineIdentity($pOnlineIdentity->getUserId(), $pOnlineIdentity->getId());
    if (!$lToken) {
      $pOnlineIdentity->setSocialPublishingEnabled(false);
      $pOnlineIdentity->save();
      return false;
    }

    $lPostBody = $this->generateMessage($pType, $pScore, $pUrl, $pTitle, $pDescription, $pPhoto);

    print_r($lPostBody);

    $lConsumer = new OAuthConsumer(sfConfig::get("app_google_oauth_token"), sfConfig::get("app_google_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "https://www.googleapis.com/buzz/v1/activities/@me/@self", $lPostBody, null, array("Content-Type: application/atom+xml"));

    return $lStatus;
  }


  public function generateMessage($pType, $pScore, $pUrl, $pTitle, $pDescription, $pPhoto) {
    $lHashtag = self::$aHashtags[$pType][$pScore];

    $lTag = substr($lHashtag, 1);

    $lPostBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:activity="http://activitystrea.ms/spec/1.0" xmlns:buzz="http://schemas.google.com/buzz/2010">';
    $lPostBody .= "<content type='html'>$pTitle $pUrl $lHashtag</content>";
    $lPostBody .= '<activity:object><activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>';

    if ($pScore > 0) {
      $lPostBody .= "<activity:verb>http://activitystrea.ms/schema/1.0/like</activity:verb>";
      $lPostBody .= "<activity:verb>http://www.yiid.org/activity/schema/$lTag</activity:verb>";
    } else {
      $lPostBody .= "<activity:verb>http://activitystrea.ms/schema/1.0/dislike</activity:verb>";
      $lPostBody .= "<activity:verb>http://www.yiid.org/activity/schema/$lTag</activity:verb>";
    }

    if ($pPhoto) {
      $lPostBody .= "<buzz:attachment><activity:object-type>http://activitystrea.ms/schema/1.0/photo</activity:object-type>";
      $lPostBody .= "<title>$pTitle</title>";
      $lPostBody .= "<content>$pTitle</content>";
      $lPostBody .= "<link rel='enclosure' type='image/jpeg' href='$pPhoto' />";
      $lPostBody .= "<link rel='preview' type='image/jpeg' href='$pPhoto' />";
      $lPostBody .= "<link rel='alternate' type='text/html' href='$pUrl' />";
      $lPostBody .= "</buzz:attachment>";
    }

    /*$lPostBody .= "<buzz:attachment>";
    $lPostBody .= "  <activity:object-type>http://activitystrea.ms/schema/1.0/article</activity:object-type>";
    //$lPostBody .= "  <title>Google Buzz buttons</title>";
    $lPostBody .= "  <link href='$pUrl' rel='alternate' type='text/html' />";
    $lPostBody .= "</buzz:attachment>";*/


    $lPostBody .= "</activity:object></entry>";

    return $lPostBody;
  }
}