<?php

/**
 * ShortUrl
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    yiid
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class ShortUrl extends BaseShortUrl
{
  /**
   * returns the shorted url
   *
   * @return string
   * @author Christian Weyand
   */
  public function getShortedUrl() {
    return sfConfig::get('app_settings_short_url') . "/".ShortUrlTable::charize($this->getId());
  }
}
