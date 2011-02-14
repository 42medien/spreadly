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
    $lUrl = $pActivity->generateUrlWithClickbackParam($this->onlineIdentity);
    $lComment =  $pActivity->getComment();
    $lHashtag =  $pActivity->generateHashtag();

    $lStatusMessage = '<?xml version="1.0" encoding="UTF-8"?><share>';
    $lStatusMessage .= "<comment><![CDATA[$lComment $lHashtag]]></comment>";
    $lStatusMessage .= '<content>';
    $lStatusMessage .= "<submitted-url><![CDATA[$lUrl]]></submitted-url>";

    if ($pActivity->getTitle()) {
      $lStatusMessage .= "<title><![CDATA[".$pActivity->getTitle()."]]></title>";
    }

    if ($pActivity->getDescr()) {
      $lStatusMessage .= "<description><![CDATA[".$pActivity->getDescr()."]]></description>";
    }

    if ($pActivity->getThumb()) {
      $lStatusMessage .= "<submitted-image-url><![CDATA[".$pActivity->getThumb()."]]></submitted-image-url>";
    }

    $lStatusMessage .= '</content>';
    $lStatusMessage .= '<visibility><code>anyone</code></visibility></share>';

    return $lStatusMessage;
  }
}
