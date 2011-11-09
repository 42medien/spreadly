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
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deal/js_init_deal.js'));
    $url = $request->getParameter("url", null);

    // handle form submit
    if ($request->getMethod() == "POST") {
      $params = $request->getParameter('like');

      $params['u_id'] = $this->getUser()->getUserId();

      if ($url) {
        $params['i_url'] = $url;
        $params['i_host'] = parse_url($url, PHP_URL_HOST);
      }

      $activity = new Documents\YiidActivity();
      $activity->fromArray($params);

      // try to save activity
      try {
        $activity->save();
        $this->redirect("@coupon?id=".$activity->getId()."&u_code=".$activity->getCCode());
      } catch (Exception $e) { // send error on exception
        $this->getLogger()->err($e->getMessage());
        $this->redirect('@default_deal');

        return sfView::SUCCESS;
      }
    }

    $deal = DealTable::getInstance()->getNextFromPool($this->getUser()->getUser());

    $this->deal = $deal;

    if (!$deal) {
      $this->setTemplate('default_deal');
    }
  }

  public function executeCoupon(sfWebRequest $request) {
    $this->getResponse()->setSlot('js_document_ready', $this->getPartial('deal/js_init_deal.js'));
    $dm = MongoManager::getDM();
    $activity = $dm->getRepository('Documents\YiidActivity')->find($request->getParameter('id'));

    if ($activity) {
      $this->deal = $activity->getDeal();
    } else {
      $this->setTemplate('default_deal');
    }
  }

  public function executeDefault_deal(sfWebRequest $request) {

  }
}
