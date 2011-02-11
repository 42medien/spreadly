<?php
/**
 * Api to post google buzz status messages
 *
 * @author Matthias Pfefferle
 */
class GooglePostApiClient extends PostApi {

  public function generateMessage($pActivity) {
    $lUrl = $pActivity->generateUrlWithClickbackParam($this->onlineIdentity);
    $lTitle = $pActivity->getTitle();
    $lPhoto = $pActivity->getThumb();
    $lScore = $pActivity->getScore();

    $lPostBody = '<entry xmlns="http://www.w3.org/2005/Atom" xmlns:activity="http://activitystrea.ms/spec/1.0" xmlns:buzz="http://schemas.google.com/buzz/2010">';
    
    if($pActivity->isDeal()) {
$lPostBody .= "<content type='html'>$lTitle $lUrl</content>";      
    } else {
      $lPostBody .= "<content type='html'>$lTitle $lUrl</content>";      
    }
    
    $lPostBody .= '<activity:object><activity:object-type>http://activitystrea.ms/schema/1.0/note</activity:object-type>';

    $lPostBody .= "<activity:verb>http://activitystrea.ms/schema/1.0/like</activity:verb>";

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