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
   *  saves are handled by the related Table-Class as we save them in MongoDB
   * (non-PHPdoc)
   * @see lib/vendor/symfony/lib/plugins/sfDoctrinePlugin/lib/vendor/doctrine/Doctrine/Doctrine_Record::save()
   */
  public function save(Doctrine_Connection $conn = null) {
    $lObjectToSave = $this->toArray(false);
    unset($lObjectToSave['id']);
    if ($this->getId()) {
      $lObjectToSave = YiidActivityTable::updateObjectInMongoDb(array('_id' => new MongoId($this->getId())), $lObjectToSave);
     return false;
    } else {
      $lObjectToSave = YiidActivityTable::saveObjectToMongoDb($lObjectToSave);
      $this->setId($lObjectToSave['_id'].""); // cast mongoID to string
    }
    if ($lObjectToSave) {
      return $lObjectToSave;
    }
    return false;
  }

  public function delete(Doctrine_Connection $con = null) {
    $this->collection->remove(array("_id" => new MongoId($this->getId()) ));
  }
  
  /**
   * This method returns the minuts/hours/day since publishing of this activity
   * 
   * @author Christian Schätzle
   */
  public function getPublishingTime() {
    $lSocialObjectDate = $this->getC();
    
    sfProjectConfiguration::getActive()->loadHelpers(array('Date'));
    $lDate = distance_of_time_in_words($lSocialObjectDate);
    
    return $lDate;
  }

}
