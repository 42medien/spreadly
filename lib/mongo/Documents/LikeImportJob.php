<?php
namespace Documents;

use Documents\Job,
    sfContext,
    Exception;

/**
 * LikeImportJob imports a users likes from facebook
 * @author Matthias Pfefferle
 * @Document
 */
class LikeImportJob extends Job {
  
  /** @String */
  protected $online_identity_id;
  
  public function __construct($online_identity_id) {
   $this->online_identity_id = $online_identity_id;
  }
    
  public function execute() {
    $online_identity = OnlineIdentityTable::getInstance()->find($this->online_identity_id);
		
		// if there is no online identity or if the identitiy isn't a facebook identity,
		// step out
		if (!$online_identity || $online_identity->getCommunity()->getCommunity() != "facebook") {
			return;
		}
		
		// trying to import likes
		try {
			FacebookImportClient::importLikes($online_identity);
		} catch (Exception $e) {
			// do nothing
		}
  }
}