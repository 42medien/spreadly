<?php


class UserIdentityConTable extends Doctrine_Table
{

  public static function getInstance()
  {
    return Doctrine_Core::getTable('UserIdentityCon');
  }

  public static function getOnlineIdentitiesForUser($pUserId) {
    $q = Doctrine_Query::create()
          ->select('uic.online_identity_id')
          ->from('UserIdentityCon uic')
          ->where('uic.user_id = ?', $pUserId);

    $lUiCons = $q->execute(array(),  Doctrine_Core::HYDRATE_NONE);
    $lUiConIds = HydrationUtils::flattenArray($lUiCons);
    return OnlineIdentityTable::getInstance()->retrieveByPks($lUiConIds);
  }

}