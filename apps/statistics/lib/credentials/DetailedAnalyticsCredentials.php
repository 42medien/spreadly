<?php
class DetailedAnalyticsCredentials {

  public static function verify() {
    $context = sfContext::getInstance();

    $domainid = $context->getRequest()->getParameter("domainid");

    if (!$domainid) {
      $dealid = $context->getRequest()->getParameter("deal_id");
      $deal = DealTable::getInstance()->find($dealid);
      $domainid = $deal->getDomainProfileId();
    }

    $domainProfile = DomainProfileTable::getInstance()->find($domainid);

    if ($domainProfile && $domainProfile->getSfGuardUserId() == $context->getUser()->getUserId() && $domainProfile->getDetailedAnalytics()) {
      return;
    } else {
      $context->getController()->forward(sfConfig::get('sf_secure_module'), sfConfig::get('sf_secure_action'));
    }
  }
}