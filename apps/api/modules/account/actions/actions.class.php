<?php

/**
 * account actions.
 *
 * @package    yiid
 * @subpackage account
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class accountActions extends BasesfApplyActions {

  /**
   * Executes index action
   *
   * @param sfRequest $request A request object
   */
  public function executeCreate(sfWebRequest $request) {
    $this->getResponse()->setContentType('application/json');
    $this->setLayout(false);

    // first api only accepts posts
    if ($request->getMethod() != "POST") {
      $this->getResponse()->setStatusCode(405);
      return $this->renderPartial("wrong_method");
    }

    // get json post
    $json_content = file_get_contents("php://input");
    sfContext::getInstance()->getLogger()->notice($json_content);

    $content = json_decode($json_content, true);
    $user = sfGuardUserTable::getInstance()->findOneBy("email_address", $content['emails'][0]['value']);

    if (!$user) {
      $captcha = sfConfig::get('app_recaptcha_enabled');
      sfConfig::set('app_recaptcha_enabled', false);
      $sfApplyApply = array();

      // set username
      if (array_key_exists("nickname", $content)) {
        $username = sfGuardUserTable::getInstance()->getUniqueUsername($content['nickname']);
        $sfApplyApply['username'] = $username;
      }

      // set first and last name
      if (array_key_exists("name", $content)) {
        $name = $content['name'];
        if (array_key_exists("givenName", $name)) {
          $sfApplyApply['firstname'] = $name['givenName'];
        }

        if (array_key_exists("familyName", $name)) {
          $sfApplyApply['lastname'] = $name['familyName'];
        }
      }

      // set email address
      if (array_key_exists("emails", $content) && (count($content['emails']) > 0)) {
        $email = $content['emails'][0];
        if (array_key_exists('value', $email)) {
          $sfApplyApply['email'] = $email['value'];
        }
      }

      $this->form = $this->newForm( 'applyForm' );

      $sfApplyApply['password'] = "testerle12345";
      $sfApplyApply['password2'] = "testerle12345";
      $sfApplyApply['tos_accepted'] = 1;
      $sfApplyApply['_csrf_token'] = $this->form->getCSRFToken();

      $this->form->bind($sfApplyApply);
      $this->form->disableLocalCSRFProtection();

      foreach($this->form->getErrorSchema()->getErrors() as $key => $error) {
        sfContext::getInstance()->getLogger()->notice(print_r($key, true));
        sfContext::getInstance()->getLogger()->notice($error->getMessage());
      }

      if ($this->form->isValid()) {
        $guid = "n" . self::createGuid();
        $this->form->getObject()->setValidate( $guid );
        $date = new DateTime();
        $this->form->getObject()->setValidateAt( $date->format( 'Y-m-d H:i:s' ) );
        $this->form->save();

        try {
          $profile = $this->form->getObject();
          $this->sendApiVerificationMail($profile);
        } catch (Exception $e) {
          sfContext::getInstance()->getLogger()->err("{ApiError} ".$e->getMessage());
        }
      }

      sfContext::getInstance()->getLogger()->notice("disch");

      sfConfig::set('app_recaptcha_enabled', $captcha);
    }

    sfContext::getInstance()->getLogger()->notice($content['emails'][0]['value']);
    //sfContext::getInstance()->getLogger()->notice(print_r($user->getUsername(), true));

    //$domain_profile = new DomainProfile();
    //$status = $domain_profile->fromApiArray($content);

    sfContext::getInstance()->getLogger()->notice($content["urls"][0]["value"]);
    //sfContext::getInstance()->getLogger()->notice($dp);
    // @todo check url claim

    // @todo add url

    // @todo verify url

    // @todo send mail-verication

    // @todo send password
  }

  /**
   * This function has been overriden. Original used Zend_Mail here. It's used
   * to actually compose and send e-mail verification message.
   * @param array $options
   */
  protected function sendApiVerificationMail( $profile ) {
    sfContext::getInstance()->getLogger()->notice("mailer");
    $options = array('subject' => 'Spreadly -Zugang zu bestätigen / account to be confirmed',
        'fullname' => $profile->getFullname(),
        'email' => $profile->getEmail(),
        'delivery_strategy' => 'realtime',
        'parameters' => array('fullname' => $profile->getFullname(),
                              'validate' => $profile->getValidate()));

    //Checking for all required options
    $required = array('subject', 'parameters', 'email', 'fullname');
    foreach ($required as $option) {
      if (!isset($options[$option])) {
        throw new sfException("Required option $option not supplied to sfApply::mail");
      }
    }
    $message = $this->getMailer()->compose();
    $message->setSubject($options['subject']);

    // Render message parts
    $message->setBody($this->getPartial('account/sendApiValidateNewText', $options['parameters']), 'text/plain');

    //getting information on sender (that's us). May be source of exception.
    $address = $this->getFromAddress();
    $message->setFrom(array($address['email'] => $address['fullname']));
    $message->setTo(array($options['email'] => $options['fullname']));

    //Sending email
    $this->getMailer()->send($message);
  }
}