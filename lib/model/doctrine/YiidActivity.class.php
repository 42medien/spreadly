<?php

/**
 * YiidActivity
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class YiidActivity extends BaseYiidActivity
{
   /**
   * runs before YiidActivity->save()
   */
  public function save(Doctrine_Connection $conn = null) {

    $lObjectToSave = $this->toArray(false);
    return $lObjectToSave = YiidActivityTable::saveObjectToMongoDb($lObjectToSave);
  }

}
