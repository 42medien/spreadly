<?php

/**
 * User filter form.
 *
 * @package    yiid
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class UserFormFilter extends BaseUserFormFilter
{
  public function configure() {
    $this->manageDealId();
  }

  public function getFields()
  {
    $fields = parent::getFields();
    $fields['deal_id'] = 'deal_id';
    return $fields;
  }

  protected function manageDealId()
  {
    $this->widgetSchema ['deal_id'] = new sfWidgetFormInput();
    $this->validatorSchema ['deal_id'] = new sfValidatorPass();
  }

  public function addDealIdColumnQuery($query, $field, $value)
  {
    Doctrine::getTable('User')->applyDealIdFilter($query, $value);
  }
}