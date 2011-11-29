<?php

/**
 * deals actions.
 *
 * @package    yiid
 * @subpackage deals
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealsActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);
    // first api only accepts posts
    if ($request->getMethod() != "POST") {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("wrong_method");
    }

    $access_token = $request->getParameter("access_token");

    // check access token
    if (!$access_token) {
      $this->getResponse()->setStatusCode(401);
      return $this->renderPartial("authentication_error");
    }

    $user = Doctrine_Core::getTable('sfGuardUser')->createQuery('u')
      ->where('u.access_token = ?', $access_token)
      ->addWhere('u.is_active = ?', true)->fetchOne();

    // check access token
    if (!$user) {
      $this->getResponse()->setStatusCode(401);
      return $this->renderPartial("authentication_error");
    }

    // check if account was setup properly
    // @todo add publisher commission
    if (!$user->getApiPriceLike() ||
        !$user->getApiPriceMediaPenetration() ||
        !$user->getApiPaymentMethod() ||
        !$user->getApiCommissionPercentage()) {
      $this->getResponse()->setStatusCode(403);
      return $this->renderPartial("setup_failure");
    }

    // get json post
    $json_content = file_get_contents("php://input");
    sfContext::getInstance()->getLogger()->notice($json_content);

    $deal = new Deal();
    $deal->setSfGuardUser($user);
    $deal->setPaymentMethod($user->getApiPaymentMethod());

    $data = json_decode($json_content, true);

    // check if data is valid json
    if (!$data) {
      $this->getResponse()->setStatusCode(406);
      return $this->renderPartial("wrong_mimetype");
    }

    $deal->fromApiArray($data);

    // set commission values
    $deal->setCommissionPercentage($user->getApiCommissionPercentage());
    $pot = round($deal->getPrice() * $user->getApiCommissionPercentage() / 100, 2, PHP_ROUND_HALF_UP);
    $deal->setCommissionPot($pot);
    $unit = round($pot / $deal->getTargetQuantity(), 2, PHP_ROUND_HALF_UP);
    $deal->setCommissionPerUnit($unit);

    // validate request
    $validate = $deal->validate();

    if ($validate !== true) {
      $this->getResponse()->setStatusCode(406);
      return $this->renderPartial("deals/wrong_fields", array("errors" => $validate));
    } else {
      $deal->save();
      $deal->complete_campaign();
      $deal->complete_share();
      $deal->complete_coupon();
      $deal->complete_billing();
      $deal->submit();
      if(array_key_exists('activate', $data) && $data['activate']===true) $deal->approve();
    }
  }
}
