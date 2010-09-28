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

  $lUser = UserTable::getInstance()->retrieveByPk($lUserId);
  if ($lUser) {
    $lUser->setLastActivity($lActivity->getC());
    $lUser->save();
  }
  $lSocialObject = SocialObjectTable::retrieveByUrlHash($lActivity->getUrlHash());
  if (!$lSocialObject) {
    $lSocialObject = SocialObjectTable::retrieveByUrl($lActivity->getUrl());
  }
  if ($lSocialObject) {
    $lSocialObject->updateObjectActingIdentities($lUserId, $lOiIds, $lServices);

    // $lActivity->setSoId(new MongoId($lSocialObject->getId()));
    // $lActivity->save();

    $pManipualtior = array('$addToSet' => array('oiids' => array('$each' => array_filter($lOiIds)),
                                              'cids' => array('$each' => array_filter($lServices))),
                             '$set' => array('so_id' => new MongoId($lSocialObject->getId()."")),
                             '$unset' => array('id' => 1),
    );

    YiidActivityTable::updateObjectInMongoDb(array('_id' => new MongoId($lActivity->getId()."")), $pManipualtior);

    echo $lUserId ." - ".count($lOiIds)." \r\n";
  }
  else {
    echo $lActivity->getId()."";
  }

}