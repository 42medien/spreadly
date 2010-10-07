<?php


class PersistentObjectTable extends Doctrine_Table {
  public static function getInstance() {
    return Doctrine_Core::getTable('PersistentObject');
  }

  /**
   * This method stores a persistent object in the database
   *
   * @param integer $userId
   * @param string $name
   * @param array $value
   */
  public static function set($userId, $name, $value) {
    $lVar = self::retrieveByUserIdAndName($name, $userId);
    if (!$lVar) {
      $lVar = new PersistentObject();
    }

    $lVar->setName( $name );
    $lVar->setUserId( $userId );
    $lVar->setValue( serialize( $value ) );
    $lVar->save();

    return $lVar;
  }

  /**
   * This method fetchs a persistent object from the database
   *
   * @param integer $userId
   * @param string $name
   * @return array
   */
  public static function get($userId, $name) {
    $lVar = self::retrieveByUserIdAndName($userId, $name);

    if ($lVar) {
      return unserialize($lVar->getValue());
    } else {
      return null;
    }
  }

  /**
   * This method removes a persistent object from the database
   *
   * @param integer $userId
   * @param string $name
   */
  public static function remove( $userId, $name ){
    $lQ = Doctrine_Query::create()
      ->delete('PersistentObject p')
      ->where('p.name = ? AND p.user_id', array($pName, $userId))
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
  public static function retrieveByUserIdAndName($pUserId, $pName) {
    $lQ = Doctrine_Query::create()
     ->from('PersistentObject p')
     ->where('p.name = ? AND p.user_id = ?', array($pName, $pUserId));

    $lObject = $lQ->fetchOne();
    return $lObject?$lObject:null;
  }
}