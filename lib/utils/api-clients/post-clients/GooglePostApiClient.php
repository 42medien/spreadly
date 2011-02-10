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
  public function doPost($pActivity) {
  	$lToken = $this->getAuthToken();
  	if (!$lToken) {
      return false;
  	}

    $lPostBody = $this->generateMessage($pActivity);

    $lConsumer = new OAuthConsumer(sfConfig::get("app_google_oauth_token"), sfConfig::get("app_google_oauth_secret"));
    $lStatus = OAuthClient::post($lConsumer, $lToken->getTokenKey(), $lToken->getTokenSecret(), "https://www.googleapis.com/buzz/v1/activities/@me/@self", $lPostBody, null, array("Content-Type: application/atom+xml"));

    return $lStatus;
  }

  public function generateMessage($pActivity) {
    $lHashtag = self::$aHashtags[$pActivity->getType()][$pActivity->getScore()];

    $lTag = substr($lHashtag, 1);
    $lUrl = $pActivity->getUrlWithClickbackParams($this->onlineIdentity);
    $lTitle = $pActivity->getTitle();
    $lPhoto = $pActivity->getThumb();
    $lScore = $pActivity->getScore();

    $lPostBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:activity="http://activitystrea.ms/spec/1.0" xmlns:buzz="http://schemas.google.com/buzz/2010">';
    $lPostBody .= "<content type='html'>$lTitle $lUrl $lHashtag</content>";
    $lPostBody .= '<activity:object><activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>';

    $lPostBody .= "<activity:verb>http://activitystrea.ms/schema/1.0/".($lScore > 0 ? 'like' : 'dislike')."</activity:verb>";
    $lPostBody .= "<activity:verb>http://www.yiid.org/activity/schema/$lTag</activity:verb>";

    if ($lPhoto) {
      $lPostBody .= "<buzz:attachment><activity:object-type>http://activitystrea.ms/schema/1.0/photo</activity:object-type>";
      $lPostBody .= "<title>$lTitle</title>";
      $lPostBody .= "<content>$lTitle</content>";
      $lPostBody .= "<link rel='enclosure' type='image/jpeg' href='$lPhoto' />";
      $lPostBody .= "<link rel='preview' type='image/jpeg' href='$lPhoto' />";
      $lPostBody .= "<link rel='alternate' type='text/html' href='$lUrl' />";
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