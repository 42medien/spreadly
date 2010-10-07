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

    $method = $request->getMethod();

      sfContext::getInstance()->getLogger()->info('{Facebookaffen}' . print_r($request->getParameterHolder(), 1));
    if ($method == 'GET' && $request->getParameter('hub_mode') == 'subscribe' &&
    $request->getParameter('hub_verify_token') == 'affen12') {
      $this->return =  $request->getParameter('hub_challenge');
      //return $this->renderText($return);
    } else if ($method == 'POST') {
      $updates = json_decode(file_get_contents("php://input"), true);
      // Replace with your own code here to handle the update
      // Note the request must complete within 15 seconds.
      // Otherwise Facebook server will consider it a timeout and
      // resend the push notification again.

      sfContext::getInstance()->getLogger()->info('{Facebookaffen}' . print_r($updates, 1));

    }
    $this->setLayout(false);
  }


  public function executeSubscribeFacebook(sfWebRequest $request) {

    $lPostBody = 'object=user&fields=home,friends,posts,likes,notes,links,statuses,picture,feed&callback_url=http://www.yiiddev.com/realtime/facebookpush&verify_token=affen12';
    $lJsonObject = json_decode(UrlUtils::sendPostRequest("https://graph.facebook.com/353988911612/subscriptions?access_token=353988911612|NBvv-WPAyMYt4XS-4lkNPzdK8KI", $lPostBody));

    var_dump($lJsonObject);
    die();
  }



  public function executeListFacebook(sfWebRequest $request) {

    $lPostBody = "";
    $lJsonObject = json_decode(UrlUtils::sendGetRequest("https://graph.facebook.com/353988911612/subscriptions?access_token=353988911612|NBvv-WPAyMYt4XS-4lkNPzdK8KI", $lPostBody));

    var_dump($lJsonObject);
    die();
  }
}
