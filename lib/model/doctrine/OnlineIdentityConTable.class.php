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
    $lOITo = OnlineIdentityTable::getInstance()->retrieveByPK($pSecondIdentityId);

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



  /**
   * retrieves all ID's of connected OI's

   * @param int $pOiId
   * @author weyandch
   * @return array(int)
   */
  public static function getIdentitysConnectedToOi($pOiId) {
    $q = Doctrine_Query::create()
          ->select('oic.to_id')
          ->from('OnlineIdentityCon oic')
          ->where('oic.from_id = ?', $pOiId);

    $lUiCons = $q->execute(array(),  Doctrine_Core::HYDRATE_NONE);
    $q->free();
    return HydrationUtils::flattenArray($lUiCons);
  }



  /**
   * checks if a connection between two OIs already exists
   *
   * @param int $pFirstIdentityId
   * @param int $pSecondIdentityId
   *
   * @return OnlineIdentityCon|false
   */
  public static function isOiCon($pFirstIdentityId, $pSecondIdentityId) {
    $lQuery = Doctrine_Query::create()
    ->from('OnlineIdentityCon oicon')
    ->where('oicon.from_id = ?', $pFirstIdentityId)
    ->andWhereIn('oicon.to_id', $pSecondIdentityId);
    $lOiCon = $lQuery->fetchOne();

    return $lOiCon?$lOiCon:false;

  }
}