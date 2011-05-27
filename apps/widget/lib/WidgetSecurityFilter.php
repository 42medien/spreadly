<?php
class WidgetSecurityFilter extends sfBasicSecurityFilter {
  public function execute($filterChain) {
    if (!$this->context->getUser()->checkDealCredentials()) {
      $this->forwardToSecureAction();
    }

    parent::execute($filterChain);
  }
}