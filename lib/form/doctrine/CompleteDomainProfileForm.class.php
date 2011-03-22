<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CompleteDomainProfileForm extends BaseDomainProfileForm
{
    public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'url'                => new sfWidgetFormInputText(),
      'protocol'           => new sfWidgetFormChoice(array('choices' => array('http' => 'http', 'https' => 'https'))),
      'state'              => new sfWidgetFormChoice(array('choices' => array('pending' => 'pending', 'verified' => 'verified'))),
      'verification_token' => new sfWidgetFormInputText(),
      'verification_count' => new sfWidgetFormInputText(),
      'sf_guard_user_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('sfGuardUser'), 'order_by' => array('id', 'DESC'), 'add_empty' => false)),
      'imprint_url'        => new sfWidgetFormTextarea(),
      'tos_url'            => new sfWidgetFormTextarea(),
      'created_at'         => new sfWidgetFormDateTime(array('default' => 'now')),
      'updated_at'         => new sfWidgetFormDateTime(array('default' => 'now')),
    ));
  }
}
