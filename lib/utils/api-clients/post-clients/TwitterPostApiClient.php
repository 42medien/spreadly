<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class TwitterPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public function generateMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');

    $lUrl = ShortUrlTable::shortenUrl($pActivity->generateUrlWithClickbackParam($this->onlineIdentity));

    $lMaxChars = 135;

    $lText = $lUrl;
    $lLengthOfText = strlen($lText);

    if ($pActivity->getComment()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getComment(), $lChars, '...') . " " . $lText;
    } elseif ($pActivity->getTitle()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getTitle(), $lChars, '...') . " " . $lText;
    }

    return array("status" => $lText);
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    $lResponse = json_decode($pResponse, true);

    if (!array_key_exists("error", $lResponse)) {
      return;
    }

    $lError = new Documents\ApiErrorLog();

    $lError->setCode("NaN");
    $lError->setMessage($lResponse['error']);
    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());

    $dm = MongoManager::getDM();
    $dm->persist($lError);
    $dm->flush();
  }
}