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

    $lText = $lUrl . " ". $pActivity->generateHashtag();
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
}
