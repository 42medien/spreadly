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
      'id' => new sfWidgetFormSelect(array('choices' => $lUrls)),
    ));

    $this->setValidators(array(
      'id' => new sfValidatorInteger(array('required' => true))
    ));

    //$this->embedRelation('Deals', 'DealForm');

//    $this->widgetSchema->setNameFormat('domainprofile[%s]');

  }
}
