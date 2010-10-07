<?php

/**
 * static actions.
 *
 * @package    yiid
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class realtimeActions extends sfActions
{
  public function executeFacebookpush(sfWebRequest $request) {
    sfContext::getInstance()->getLogger()->debug('{Facebookaffen}' . print_r($request, 1));
  }


  public function executeSubscribeFacebook(sfWebRequest $request) {

   $lJsonObject = json_decode(UrlUtils::sendPostRequest("https://graph.facebook.com/353988911612/subscriptions?access_token=353988911612|fd118fd8fb5da426565eebb7-1336043259|xgFkdHetCbudF2lv0tWi7ockbFY&object=user&fields=name,picture,feed&callback_url=http://www.yiiddev.com/realtime/facebookpush", ''));

   var_dump($lJsonObject);
   die();
  }
}
