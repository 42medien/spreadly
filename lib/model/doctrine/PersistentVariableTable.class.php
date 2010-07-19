<?php


class PersistentVariableTable extends Doctrine_Table
{
  const YIID_TWITTER = "yiid-twitter";

  public static function getInstance()
  {
    return Doctrine_Core::getTable('PersistentVariable');
  }


  /**
   * set a persitentVariable
   * @param string $pName
   * @param string $pValue
   * @param boolean $pReturn
   */
  public static function set( $pName, $pValue, $pReturn = false ){
    $lVar = self::retrieveByName($pName);
    if (!$lVar) {
      $lVar = new PersistentVariable();
    }

    $lVar->setName( $pName );
    $lVar->setValue( serialize( $pValue ) );
    $lVar->save();

    if($pReturn) {
      return $lVar;
    }
  }


  /**
   * retrieves the unserialized value stored in a varialbe
   *
   * @param string $pName
   */
  public static function get( $pName ){
    $lVar = self::retrieveByName($pName);

    if ($lVar) {
      return unserialize($lVar->getValue());
    } else {
      return null;
    }
  }


  /**
   *
   * deletes stores variable
   * @param $pName
   */
  public static function remove( $pName ){
    $lQ = Doctrine_Query::create()
    ->delete('PersistentVariable p')
    ->where('p.name = ?', $pName)
    ->execute();
  }

  /**
   * This function returns the persistent variable with the transfered name
   *
   * @author Christian Schätzle
   *
   * @param string $pName
   * @return PersistentVariable
   */
  public static function retrieveByName($pName) {
    $lQ = Doctrine_Query::create()
    ->from('PersistentVariable p')
    ->where('p.name = ?', $pName);

    $lObject = $lQ->fetchOne();
    return $lObject?$lObject:null;
  }

}