<?php

/**
 * SocialAdvertisement
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class SocialAdvertisement extends BaseSocialAdvertisement
{


  /**
   * runs before SocialAdvertisement->save()
   *
   * @author Christian Weyand
   * @param Doctrine_Event $pEvent
   */
  public function preInsert($pEvent) {
    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($this->getUrl());

    if (!$lSocialObject) {
      SocialObjectTable::createSocialObject($this->getUrl(), null, $this->getTitle(), $this->getDescription());
      $lSocialObject = SocialObjectTable::retrieveByAliasUrl($this->getUrl());
    }
    $this->setSoId($lSocialObject->getId());
  }
}
