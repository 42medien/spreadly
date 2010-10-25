<?php
/**
 * PostApi Interface
 *
 * @author Matthias Pfefferle
 */
abstract class PostApi {
  public static $aHashtags = array("like" => array("1" => "#like", "-1" => "#dislike"),
                            "pro" => array("1" => "#pro", "-1" => "#contra"),
                            "recommend" => array("1" => "#recommend", "-1" => "#reject"),
                            "visit", array("1" => "#visit", "-1" => "#miss"),
                            "nice", array("1" => "#nice", "-1" => "#ugly"),
                            "buy", array("1" => "#buy", "-1" => "#dontbuy"),
                            "rsvp", array("1" => "#attend", "-1" => "#miss"));

  /**
   * defines the post function
   *
   * @param OnlineIdentity $pOnlineIdentity
   * @param string $pUrl if the url is not part of the message
   * @param string $pType
   * @param string $pScore
   * @param string $pTitle
   * @return int status code
   */
  abstract public function doPost(OnlineIdentity $pOnlineIdentity, $pUrl, $pType, $pScore, $pTitle = null, $pDescription = null, $pPhoto = null);
}