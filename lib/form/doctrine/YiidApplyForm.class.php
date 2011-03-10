<?php

/**
 * Extending origninal form for adding the tos_accepted checkbox validator and label
 * @author hannes
 */
class YiidApplyForm extends sfApplyApplyForm
{
  public function configure()
  {
    parent::configure();
    $this->setValidator( 'tos_accepted', new sfValidatorBoolean(array('required' => true)) );
    $this->widgetSchema->setLabel('tos_accepted', 'Accept <a href="http://spreadly.com/system/tos" target="_blank">Terms of Service</a>');
  }
}
