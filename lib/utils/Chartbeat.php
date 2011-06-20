<?php
/**
 * class to access the chartbeat api
 *
 * @author Matthias Pfefferle
 */
class Chartbeat {

  private $apikey = null;

  public function __construct() {
    $this->apikey = sfConfig::get("app_chartbeat_apikey");
  }

  /**
   * get the data_series informations
   *
   * @link http://chartbeat.pbworks.com/w/page/26872013/data_series
   * @param string $selecor
   * @return array
   */
  public function getDataSeriesByDate($selector) {
    switch ($selector) {
      case "today":
        $timestamp = strtotime("today");
        $days = 1;
        $minutes = 60;
        break;
      case "yesterday":
        $timestamp = strtotime("yesterday");
        $days = 2;
        $minutes = 60;
        break;
      case "last7d":
        $days = 7;
        $minutes = 1440;
        break;
      case "last30d":
        $days = 30;
        $minutes = 1440;
        break;
    }

    $url = "http://chartbeat.com/data_series/?days=".$days."&host=spread.ly&type=summary&val=people&minutes=".$minutes."&apikey=".$this->apikey;

    if (isset($timestamp)) {
      $url .= '&amp;timestamp='.$timestamp;
    }

    $json = UrlUtils::getUrlContent($url);
    $data = json_decode($json, true);

    array_walk($data['people'], function(&$el) {
       if($el == null) {
          $el = 0;
        }
      });

    return $data;
  }
}