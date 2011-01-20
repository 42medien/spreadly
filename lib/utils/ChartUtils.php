<?php

class ChartUtils {
      
  public static function getCategories($filter) {    
    $start = strtotime($filter['fromDate']);
    $end = strtotime($filter['toDate']);
    $range = array();
    
    $short = $end-$start>=7*24*3600;
    
    do {
      $range[] = $short ? date('d.', $start) : date('d. M', $start);
      $start = strtotime("+ 1 day", $start);
    } while($start <= $end);

    return $range;
  }
  
  public static function getPiData($rawPis) {
    $rawPis = ChartUtils::sortArrayByDate($rawPis);
    $res = array();
    $res['total'] = array();
    $res['cb'] = array();
    $res['yiid'] = array();
  
    // Converting data into a chart usable format
    foreach ($rawPis as $data) {
      $res['total'][] = array_key_exists('total', $data) ? $data['total'] : 0;
      $res['cb'][] = array_key_exists('cb', $data) ? $data['cb'] : 0;
      $res['yiid'][] = array_key_exists('yiid', $data) ? $data['yiid'] : 0;
    }
    return $res;
  }
  
  public static function dateRangeArray($start, $end) {
  }
  
  // Sort function for sorting by date
  private static function sortByDate($a, $b) { 
    if ($a['date'] == $b['date']) {
        return 0;
    }
    return ($a['date'] < $b['date']) ? -1 : 1;
  }
  
  // Sorting the data array by date
  public static function sortArrayByDate($array) {
    uasort($array, "ChartUtils::sortByDate");
    return $array;
  }
  
  // Sort function for sorting by date
  private static function sortByTotals($a, $b) { 
    if ($a['total'] == $b['total']) {
        return 0;
    }
    return ($a['total'] < $b['total']) ? 1 : -1;
  }
  
  // Sorting the data array by date
  public static function sortArrayByTotals($array, $limit=10) {
    uasort($array, "ChartUtils::sortByTotals");
    $array = array_slice($array, 0, $limit);
    return $array;
  }
  
  public static function convertDataForKeys($keys, $datas, $indexed=false) {
    $res = array();
    for ($i=0; $i < count($keys); $i++) { 
      if($indexed) {
        $res[$i] = 0;
      } else {
        $res[$keys[$i]] = 0;
      }
    }  

    foreach ($datas as $data) {
      for ($i=0; $i < count($keys); $i++) { 
        if(array_key_exists($keys[$i], $data)) {
          if($indexed) {
              $res[$i] += $data[$keys[$i]];
          } else {
            $res[$keys[$i]] += $data[$keys[$i]];
          }
        }          
      }
    }
    return $res; 
  }
  
  public static function addFilterData($res, $filter) {
    $res = array();
    $res['raw_filter'] = $filter;
    $res['categories'] = ChartUtils::getCategories($filter);
    $res['range'] = $filter['fromDate']." - ".$filter['toDate'];
    
    $res['startdate'] = array();
    $res['startdate']['year'] = intval(date('Y', strtotime($filter['fromDate'])));
    $res['startdate']['month'] = intval(date('m', strtotime($filter['fromDate'])))-1;
    $res['startdate']['day'] = intval(date('d', strtotime($filter['fromDate'])));

    return $res;
  }
  
  public static function getActivitiesForAllServices($rawData, $services) {
    $temp = array();
    // Initializing the Data arrays for the chart
    foreach ($services as $service) {
      $temp[$service.'_likes'] = array();
      $temp[$service.'_dislikes'] = array();
    }
    
    // Sort data by date
    $rawData['data'] = ChartUtils::sortArrayByDate($rawData['data']);
  
    // Converting data into a chart usable format
    foreach ($rawData['data'] as $data) {
      foreach ($services as $service) {
        if(array_key_exists($service, $data)) {
          array_push($temp[$service.'_likes'], $data[$service]['likes']);
          array_push($temp[$service.'_dislikes'], $data[$service]['dislikes']);
        } else {
          array_push($temp[$service.'_likes'], 0);
          array_push($temp[$service.'_dislikes'], 0);
        }
      }
    }
    return $temp;
  }
}

?>