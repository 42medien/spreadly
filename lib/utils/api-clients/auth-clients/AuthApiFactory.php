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
   * @param int $pCommunity
   * @param array $pParams
   * @return Object
   */
  static public function factory($pCommunity, $pParams = null) {
    // return matching object
    switch ($pCommunity) {
      case "facebook":
        return new FacebookAuthApiClient();
        break;
      case "twitter":
        return new TwitterAuthApiClient();
        break;
      /*case sfConfig::get('app_likewidget_google'):
        return new BuzzPostApiClient();
        break;*/
      default:
        return null;
    }
  }
}