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

    $lStatusMessage = '<?xml version="1.0" encoding="UTF-8"?><share>';
    $lStatusMessage .= "<comment><![CDATA[".substr($lComment, 0, 700)."]]></comment>";
    $lStatusMessage .= '<content>';
    $lStatusMessage .= "<submitted-url><![CDATA[$lUrl]]></submitted-url>";

    if ($pActivity->getTitle()) {
      $lStatusMessage .= "<title><![CDATA[".substr($pActivity->getTitle(), 0, 200)."]]></title>";
    }

    if ($pActivity->getDescr()) {
      $lStatusMessage .= "<description><![CDATA[".substr($pActivity->getDescr(), 0, 256)."]]></description>";
    }

    if ($pActivity->getThumb()) {
      $lStatusMessage .= "<submitted-image-url><![CDATA[".$pActivity->getThumb()."]]></submitted-image-url>";
    }

    $lStatusMessage .= '</content>';
    $lStatusMessage .= '<visibility><code>anyone</code></visibility></share>';

    return $lStatusMessage;
  }

  protected function handleResponse($pResponse) {
    parent::handleResponse($pResponse);
    if (!preg_match('~<error>~i', $pResponse)) {
      return;
    }

    libxml_use_internal_errors(true);
    $lDoc = new DOMDocument();
    $lDoc->loadXML($pResponse);

    $lError = new Documents\ApiErrorLog();

    foreach ($lDoc->getElementsByTagName('error-code') as $code) {
      $lError->setCode($code->nodeValue);
    }

    foreach ($lDoc->getElementsByTagName('message') as $message) {
      $lError->setMessage($message->nodeValue);
    }

    $lError->setOiId($this->onlineIdentity->getId());
    $lError->setUId($this->onlineIdentity->getUserId());
    $lError->save();
  }
}
