<?php

/**
 * Deal form.
 *
 * @package    yiid_stats
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class DealTosForm extends BaseDealForm
{
  public function configure()
  {

    //var_dump($this->getValues());die();

    $this->setWidgets(array(
      'tos_accepted'      => new sfWidgetFormInputCheckbox(),
    ));

    $this->setDefaults(
    	array(
    		'start_date' => date('Y-m-d G:i'),
    		'end_date' => date('Y-m-d G:i')
    	)
    );

    $this->setValidators(array(
      'tos_accepted'      => new sfValidatorBoolean(array('required' => true), array('required' => 'tosaccepted required')),
    ));

    $this->widgetSchema->setNameFormat('dealtos[%s]');
  }
}
