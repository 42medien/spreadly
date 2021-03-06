<?php
/**
 * PostApi Factory
 *
 * @author Matthias Pfefferle
 */
class AuthApiFactory {

  /**
   * returns the matching PostApiClient
   *
   * @author Matthias Pfefferle
   * @param mixed $pCommunity the community name or the community id
   * @param array $pParams
   * @return Object
   */
  static public function factory($pCommunity, $pParams = null) {
    // check if $pCommunity is the name or the id
    if (is_numeric($pCommunity)) {
      $lCommunityObject = CommunityTable::getInstance()->retrieveByPk($pCommunity);
      $lCommunity = $lCommunityObject->getCommunity();
    } else {
      $lCommunity = $pCommunity;
    }


    // return matching object
    switch ($lCommunity) {
      case "facebook":
        return new FacebookAuthApiClient();
        break;
      case "twitter":
        return new TwitterAuthApiClient();
        break;
      case "tumblr":
        return new TumblrAuthApiClient();
        break;
      case "linkedin":
        return new LinkedinAuthApiClient();
        break;
      case "xing":
        return new XingAuthApiClient();
        break;
      case "flattr":
        return new FlattrAuthApiClient();
        break;
      case "yigg":
        return new YiggAuthApiClient();
        break;
      default:
        return null;
    }
  }
}