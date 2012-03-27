<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class XingPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public function generateMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');

    $lUrl = $pActivity->generateUrlWithClickbackParam($this->onlineIdentity);

    $lMaxChars = 415;

    $lText = $lUrl;
    $lLengthOfText = strlen($lText);

    if ($pActivity->getComment()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getComment(), $lChars, '...') . " " . $lText;
    } elseif ($pActivity->getTitle()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getTitle(), $lChars, '...') . " " . $lText;
    }

    return array("message" => $lText);
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    $lResponse = $pResponse;

    if ($lResponse != "ACCESS_DENIED" && $lResponse != "USER_NOT_FOUND") {
      return;
    }

    $lError = new Documents\ApiErrorLog();

    $lError->setCode("403");
    $lError->setMessage($lResponse);
    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());
    $lError->save();

    $this->onlineIdentity->deactivate();
  }
}