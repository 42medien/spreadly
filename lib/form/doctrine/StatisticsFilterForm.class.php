<?php

/**
 * Login form for navigation header.
 * 
 * @package    yiid_stats
 * @subpackage form
 * @author     Hannes Schippmann
 * @version    SVN: $Id$
 */
class StatisticsFilterForm extends BaseForm
{
  /**
   * @see sfForm
   */
  public function setup()
  {
    $user = sfContext::getInstance()->getUser()->getGuardUser();
    $query = DomainProfileTable::getInstance()->createQuery()->where('sf_guard_user_id = ? AND state = ?', array($user->getId(), DomainProfileTable::STATE_VERIFIED));
    
    $this->setWidgets(array(
      'host_id' => new sfWidgetFormDoctrineChoice(array('query' => $query, 'model' => 'DomainProfile', 'method' =>    'getDomain', 'add_empty' => 'Alle', 'label' => __('Website'))),
      'month' => new sfWidgetFormInputText()
    ));
  }
}
