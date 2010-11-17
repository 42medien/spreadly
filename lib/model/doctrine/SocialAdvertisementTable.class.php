<?php


class SocialAdvertisementTable extends Doctrine_Table {
  public static function getInstance() {
    return Doctrine_Core::getTable('SocialAdvertisement');
  }

  public static function getRandomAd() {
    $q = Doctrine_Query::create()
      ->select('sa.id, RANDOM() AS rand')
      ->from('SocialAdvertisement sa')
      ->orderby('rand')
      ->limit(1);

    $lObject = $q->execute();

    return $lObject[0];
  }
}