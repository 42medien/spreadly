<?php

require_once(dirname(__FILE__).'/../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'prod', true);

sfContext::createInstance($configuration);

$logger = sfContext::getInstance()->getLogger();

// Initialize database manager.
$dbManager = new sfDatabaseManager($configuration);
$dbManager->loadConfiguration();


$lActivities = YiidActivityTable::retrieveAllObjects();


foreach ($lActivities as $lActivity) {
  $lUserId = $lActivity->getUId();
  $pOnlineIdenities = UserIdentityConTable::getOnlineIdentitiesForUser($lUserId);

  $lOiIds = array();
  $lServices = array();
  foreach ($pOnlineIdenities as $oi) {
    if ($oi->getSocialPublishingEnabled()) {
      $lOiIds[] = $oi->getId();
      $lServices[] = $oi->getCommunityId();
    }
  }

  $pManipualtior = array('$addToSet' => array('oiids' => array('$each' => array_filter($lOiIds)),
                                              'cids' => array('$each' => array_filter($lServices))
                                              ),
                         );

YiidActivityTable::updateObjectInMongoDb(array('u_id' => $lUserId, 'url_hash' => $lActivity->getUrlHash()), $pManipualtior);

  $lSocialObject = SocialObjectTable::retrieveByUrlHash($lActivity->getUrlHash());
  if (!$lSocialObject) {
    $lSocialObject = SocialObjectTable::retrieveByUrl($lActivity->getUrl());
  }
  if ($lSocialObject) {
    $lSocialObject->updateObjectActingIdentities($lOiIds, $lServices);

    $lActivity->setSoId(new MongoId($lSocialObject->getId()));
    $lActivity->save();
    echo $lUserId ." - ".count($lOiIds)." \r\n";
  }
  else {
    echo "################################################### " .$lActivity->getUrl()."\r\n";
  }

}