<?php
namespace Repositories;

use Doctrine\ODM\MongoDB\DocumentRepository,
    \UserTable,
    \MongoManager,
    Documents\UserRank;

class UserRankRepository extends DocumentRepository {
	
	/**
	 * get the latest entries
	 *
	 * @param int $limit
	 * @param int $offset
	 */
	public function getCurrent($user_id) {
    $rank = $this->getByDay($user_id, date("d"), date("m"), date("Y"));
    
    if ($rank) {
      //return $rank->getRank();
    }
    
    return intval($this->generateFor($user_id));
	}
  
  public function generateFor($user_id) {
    $user = UserTable::getInstance()->find($user_id);
    
    if ($user->getFriendCount() == 0 || $user->getShareCount() == 0) {
      $rank = 0;
    } else {
      $rank = (($user->getClickbackCount() / $user->getShareCount()) / $user->getFriendCount()) * 100;
    }
    
    $user_rank = new UserRank();
    $user_rank->setRank(intval($rank));
    $user_rank->setUserId(intval($user_id));
    $user_rank->save();

    return $rank;
  }
  
  public function getByDay($user_id, $day, $month, $year) {
    $dm = MongoManager::getDM();
    return $dm->getRepository("Documents\UserRank")->findOneBy(array("u_id" => intval($user_id), "d" => intval($day), "m" => intval($month), "y" => intval($year)));
  }
}