<?php
/**
 * the referer-filter chekcs if the user comes from a search engine
 *
 * @author Matthias Pfefferle
 */
class RefererFilter extends sfFilter {
  public function execute($filterChain) {
    // check if it is the first call
    if ($this->isFirstCall()) {
      // check if the user comes from a search engine
      // and is not authenticated
      // and if the module != xml
      if (($this->getContext()->getRequest()->getParameter('module') != 'xml') && !$this->getContext()->getUser()->isAuthenticated() &&
          SearchEngineUtils::checkReferer($this->getContext()->getRequest()->getReferer())) {
        $this->getContext()->getController()->getAction('index', 'index')->forward('index', 'slim');
      }
    }
    // execute next filter
    $filterChain->execute();
  }
}
?>