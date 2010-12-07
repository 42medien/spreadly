<?php
class staticComponents extends sfComponents {
  public function executeNavbar(sfWebRequest $request) {
    $lUrl = $request->getParameter('url', '');

    // if there is no param
    if (!$lUrl) {
      // check "static_like_with_params" in the session
      $lRedirectUrl = $this->getUser()->getAttribute("static_like_with_params", null, "popup");
      if ($lRedirectUrl) {
        // parse the url to get the query-string
        $lQuery = parse_url($lRedirectUrl, PHP_URL_QUERY);
        $lArray = array();
        // parse the query string to get th url-param
        parse_str($lQuery, $lArray);
        // check if param exists
        if (array_key_exists("url", $lArray)) {
          $lUrl = $lArray['url'];
        }
      }
    }

    // if there is an url, check if there is a matching deal
    if ($lUrl) {
      $lUrl = urldecode($lUrl);
      $this->pDeal = DealTable::getActiveDealByUrlAndUserId($lUrl, $this->getUser()->getUserId());
    }
  }
}
?>