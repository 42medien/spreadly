<?php

/**
 * deal actions.
 *
 * @package    yiid
 * @subpackage deal
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dealActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request) {
    $url = $request->getParameter("url", null);

    // handle form submit
    if ($request->getMethod() == "POST") {
      $params = $request->getParameter('like');

      $params['u_id'] = $this->getUser()->getUserId();
      $params['i_url'] = $url;

      $activity = new Documents\YiidActivity();
      $activity->fromArray($params);

      // try to save activity
      try {
        $activity->save();
        $this->redirect("@coupon?id=".$activity->getId());
      } catch (Exception $e) { // send error on exception
        $this->getLogger()->err($e->getMessage());
      }
    }

    $deal = DealTable::getInstance()->getNextFromPool($this->getUser()->getUser());

    $this->deal = $deal;

    if (!$deal) {
      $this->setTemplate('default_deal');
    }
  }

  public function executeCoupon(sfWebRequest $request) {
    $dm = MongoManager::getDM();
    $activity = $dm->getRepository('Documents\YiidActivity')->find($request->getParameter('id'));

    if ($activity) {
      $this->deal = $activity->getDeal();
    }
  }
}
