<?php
/**
 * Api to post twitter status messages
 *
 * @author Matthias Pfefferle
 */
class LinkedinPostApiClient extends PostApi {

  /**
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param YiidActivity $pActivity
   * @return string
   */
  public function generateMessage($pActivity) {
    sfProjectConfiguration::getActive()->loadHelpers(array('Text', 'Url', 'Tag'));

    $lHashtag = self::$aHashtags[$pActivity->getType()][$pActivity->getScore()];
    $lUrl = $pActivity->getUrlWithClickbackParam($this->onlineIdentity);
    
    $lStatusMessage = '<?xml version="1.0" encoding="UTF-8"?><share>';
    $lStatusMessage .= "<comment>".$lHashtag."</comment>";
    $lStatusMessage .= '<content>';
    $lStatusMessage .= "<submitted-url>$lUrl</submitted-url>";

    if ($pActivity->getTitle()) {
      $lStatusMessage .= "<title>".$pActivity->getTitle()."</title>";
    }

    if ($pActivity->getDescr()) {
      $lStatusMessage .= "<description>".$pActivity->getDescr()."</description>";
    }

    if ($pActivity->getThumb()) {
      $lStatusMessage .= "<submitted-image-url>".$pActivity->getThumb()."</submitted-image-url>";
    }

    $lStatusMessage .= '</content>';
    $lStatusMessage .= '<visibility><code>anyone</code></visibility></share>';

    return $lStatusMessage;
  }
}
