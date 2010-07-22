<?php //vim: foldmethod=marker
//require_once("OAuth.php");

/**
 * Enter description here...
 *
 * @author Matthias Pfefferle
 */
class OAuthSymfonyServer extends OAuthServer {
  /**
   * returns all signature methods
   *
   * @return array
   */
  public function get_signature_methods() {
    return $this->signature_methods;
  }

  /**
   * constructor to set the signatures
   */
  public function __construct() {
    $this->add_signature_method(new OAuthSignatureMethod_HMAC_SHA1());

    parent::__construct(new OAuthSymfonyStore());
  }

  /**
   * store the request into the session
   *
   * @param sfWebRequest $pRequest
   */
  public function storeRequestToSession( $pOAuthRequest = null ){
    if (!isset($pOAuthRequest)) {
      sfContext::getInstance()->getUser()->setAttribute('rememberedOAuthRequest', null );
    } else {
      sfContext::getInstance()->getUser()->setAttribute('rememberedOAuthRequest', serialize($pOAuthRequest) );
    }
  }

  /**
   * load the request from the session1
   *
   * @return sfWebRequest | null
   */
  public function loadRequestFromSession(){
    if( $lReq = sfContext::getInstance()->getUser()->getAttribute('rememberedOAuthRequest') ){
      return unserialize($lReq);
    }
    return null;
  }
}
?>
