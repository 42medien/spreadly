<?php

/**
 *
 *
 * @author hannes
 */
class DealUtils {
  const MONGO_COLLECTION = 'deals';

  public static function dealActive($pUrl) {
    $host = parse_url($pUrl, PHP_URL_HOST);
    $col = DealUtils::getCollection();
    $today = new MongoDate(strtotime("today"));
    $cond = array(
      "host" => $host,
      "start_date" => array('$lte' => $today),
      "end_date" => array('$gte' => $today)
    );
    $result = $col->find($cond)->limit(1)->sort(array("start_date" => -1));
    return $result->hasNext() ? $result->getNext() : false;
  }

  private static function getCollection() {
    $lMongo = new Mongo(LikeSettings::MONGO_HOSTNAME);
    return $lMongo->selectCollection(LikeSettings::MONGO_DATABASENAME, self::MONGO_COLLECTION);
  }
}