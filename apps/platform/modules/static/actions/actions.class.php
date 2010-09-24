<?php

/**
 * static actions.
 *
 * @package    yiid
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class staticActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $lPage = $request->getParameter('page');
    $lCategory = $request->getParameter('category');

    try {
      $lCms = CmsTable::getCmsByPageAndCategory($lPage, $lCategory);
      $this->pHeadline = $lCms->getHeadline();
      $this->pText = $lCms->getText();

    } catch (ModelException $e) {
      $this->forward404();
    }
  }

  /**
   * Executes list action
   *
   * @return null
   */
  public function executeList() {
    $lCategory = $this->getRequestParameter('category');

    try {
      $this->lCmsLinks = CmsPeer::getCmssByCategory($lCategory);
      $this->headline = CmsCategoryPeer::getCategoryByName($lCategory);
    } catch (ModelException $e) {
      $this->forward404();
    }

    Breadcrumb::getInstance()->addItem($this->headline->getTitle(), '@cms_list?category=' . $lCategory);

    return;
  }

  public function execute404() {
    Breadcrumb::getInstance()->clearItems();
  }

  public function execute500() {
    Breadcrumb::getInstance()->clearItems();
    $lCms = CmsPeer::getCmsByPageAndCategory('500', 'system');
    $this->headline = $lCms->getHeadline();
    $this->text = $lCms->getText();

    $this->setTemplate('index');
  }

  public function executePrivacy_policy() {
    $this->redirect('static/index?category=rechtliches&page=privacy');
  }

  private function getCulture() {
    $culture = $this->getUser()->getCulture();

    return substr($culture, 0, 2);
  }

  public function executeContactform(sfWebRequest $request) {
    if ($lUser = $this->getUser()->getUser()) {
      $this->emailAddress = $lUser->getEmail();
      $this->fullName = $lUser->getFullname();
    } else {
      $this->emailAddress = '';
      $this->fullName  = '';
    }
     // form with prefilled data on registered users
    $this->form = new ContactForm(array('email' => $this->emailAddress, 'name' => $this->fullName));
    if ($request->isMethod('post'))
    {
      $this->form->bind($request->getParameter('contact'));
      if ($this->form->isValid())
      {
        $this->getUser()->setFlash('info', 'INFO_SEND_CONTACTEMAIL', true);
        $this->sent = true;
        $values = $this->form->getValues();
        $lBody = $values['name'].' hat folgende Anfrage über das Communipedia-Kontaktformular gesendet:'."\n\n".$values['message'];

        Mailer::send(sfConfig::get('app_emailaddress_info'), $values['email'], $values['subject'], $lBody);

      }
    }
    //$this->setLayout('layout_search');
  }

  public function executeSend_contact_mail(){

    $lContact = $this->getRequestParameter('contactform');

    try {
      $lBody = $lContact['firstname'].' '.$lContact['lastname'].' hat folgende Anfrage über das Communipedia-Kontaktformular gesendet:'."\n\n".$lContact['msg'];

      Mailer::send(sfConfig::get('app_emailaddress_info'), $lContact['email'], $lContact['subject'], $lBody);
      $this->getUser()->setFlash('info', 'INFO_SEND_CONTACTEMAIL' );
      $this->redirect('static/contactform');
    } catch (Exception $e){
      sfConfig::getInstance()->getLogger()->err("{yiid}" . $e->getMessage());
      $this->redirect('static/contactform');
    }

  }


  public function executePress_register() {
    $this->setLayout('layout_new');
  }

  public function executePress_deregister() {
    $this->setLayout('layout_new');
  }

  public function executePress_archive($request) {
    $lUrl = 'http://redirect2.mailingwork.de/mailingarchive.php?C=299a23a2291e2126b91d54f3601ec162&L=10ce75ac40fc149330ea64671feda328&P=e8a401ac';
    $lContent = UrlUtils::getUrlContent($lUrl);
    $lData = unserialize($lContent);
    $this->pData = $lData;

    $this->setLayout('layout_new');
  }

  public function executeNewsletter_register() {
    $this->setLayout('layout_new');
  }

  public function executeNewsletter_deregister() {
    $this->setLayout('layout_new');
  }

  public function executeNewsletter_archive($request) {
    $lUrl = 'http://redirect2.mailingwork.de/mailingarchive.php?C=299a23a2291e2126b91d54f3601ec162&L=441d9b1d721e29971edc93bca39bf497&P=3001afbe';
    $lContent = UrlUtils::getUrlContent($lUrl);
    $lData = unserialize($lContent);
    $this->pData = $lData;

    $this->setLayout('layout_new');
  }
  
  public function executeImprint(sfWebRequest $request) {
  	
  }
  
  public function executeTos(sfWebRequest $request) {
    
  }
}
