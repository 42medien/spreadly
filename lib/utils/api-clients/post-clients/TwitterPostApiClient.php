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
  public static function generateMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');
    
    $lUrl = ShortUrlTable::shortenUrl($pActivity->getUrlWithClickbackParam($this->onlineIdentity));

    $lMaxChars = 135;

    $lText = $lUrl . " #like";
    $lLengthOfText = strlen($lText);

    if ($pActivity->getTitle()) {
      $lChars = $lMaxChars - $lLengthOfText;
      $lText = truncate_text($pActivity->getTitle(), $lChars, '...') . " " . $lText;
    }

    return array("status" => $lText);
  }
}
