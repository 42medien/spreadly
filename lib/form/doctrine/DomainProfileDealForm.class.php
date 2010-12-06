<?php

/**
 * DomainProfile form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DomainProfileDealForm extends BaseDomainProfileForm
{
  public function configure()
  {

  	$lI18n = sfContext::getInstance()->getI18N();

    $lVerifiedDomains = DomainProfileTable::retrieveVerifiedForUser(sfContext::getInstance()->getUser()->getGuardUser());
    $lUrls = array();
    foreach($lVerifiedDomains as $lDomain) {
      $lUrls[$lDomain->getId()] = $lDomain->getUrl();
    }

    $this->setWidgets(array(
      'imprint_url' => new sfWidgetFormInputText(),
      'id' => new sfWidgetFormSelect(array('choices' => $lUrls)),
    ));

    $this->setValidators(array(
      'imprint_url' => new sfValidatorUrl(array('max_length' => 512, 'required' => true), array('invalid' => $lI18n->__('Invalid Url'))),
      'id' => new sfValidatorInteger(array('required' => true))
    ));
    
    //$this->embedRelation('Deals', 'DealForm');

//    $this->widgetSchema->setNameFormat('domainprofile[%s]');

  }
}
