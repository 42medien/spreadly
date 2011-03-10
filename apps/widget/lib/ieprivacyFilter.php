<?php
/**
 * adds p3p headers to widget app responses
 *
 * @author weyandch
 */
class ieprivacyFilter extends sfFilter {
  public function execute($filterChain) {
    // check if it is the first call
    if ($this->isFirstCall()) {
      $this->getContext()->getResponse()->setHttpHeader("P3P", 'CP="DSP LAW"', true);
    }
    // execute next filter
    $filterChain->execute();
  }
}