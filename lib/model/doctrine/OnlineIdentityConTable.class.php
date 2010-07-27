<?php
/**
 * Enter description here...
 *
 */
class OnlineIdentityConTable extends Doctrine_Table {

  public static function getInstance() {
    return Doctrine_Core::getTable('OnlineIdentityCon');
  }

  /**
   * connect to ois manually
   *
   * @param int $pUserID
   * @param int $pFirstIdentityId
   * @param int $pSecondIdentityId
   * @throws ModelException
   * @return OnlineIdentityCon
   */
  public static function createNew($pFirstIdentityId, $pSecondIdentityId) {
    $lOIFrom = OnlineIdentityTable::getInstance()->retrieveByPK($pFirstIdentityId);
    $lOITo = OnlineIdentityPeer::getInstance()->retrieveByPK($pSecondIdentityId);

    // validation
    if (($lOIFrom == null) || ($lOITo == null)) {
      throw new ModelException('one or both online-identities are wrong', ModelException::NOT_ALLOWED);
    } elseif (self::isOiCon($pFirstIdentityId, $pSecondIdentityId)) {
      throw new ModelException('there is already a user connection', ModelException::NOT_ALLOWED);
    } elseif ($lOIFrom->getCommunityId() != $lOITo->getCommunityId()) {
      throw new ModelException("you can't connect two different communities", ModelException::NOT_ALLOWED);
    }

    $lOICon = new OnlineIdentityCon();
    $lOICon->setFromId($pFirstIdentityId);
    $lOICon->setToId($pSecondIdentityId);
    $lOICon->save();

    return $lOICon;
  }
}