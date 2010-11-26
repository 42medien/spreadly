<?php
/**
 * the chart data helper
 *
 * @author hannes
 */

/**
 * Helper that gets raw mongo data and converts it to a format suitable for the chart
 *
 * @param raw_data
 * @return converted data
 */
function getActivityChartData($rawData) {
  $res = array();
  $services = array('facebook', 'twitter', 'linkedin', 'google');
  $res['clickbacks'] = array();
  
  // Initializing the Data arrays for the chart
  foreach ($services as $service) {
    $res[$service.'_likes'] = array();
    $res[$service.'_dislikes'] = array();
  }
  
  // Sort data by date
  $rawData['data'] = ChartUtils::sortArrayByDate($rawData['data']);
  
  // Converting data into a chart usable format
  foreach ($rawData['data'] as $data) {
    foreach ($services as $service) {
      if(array_key_exists($service, $data)) {
        array_push($res[$service.'_likes'], $data[$service]['likes']);
        array_push($res[$service.'_dislikes'], $data[$service]['dislikes']);
      } else {
        array_push($res[$service.'_likes'], 0);
        array_push($res[$service.'_dislikes'], 0);
      }
    }    
  }

  // Get pi data by date
  $res['pis'] = ChartUtils::getPiData($rawData['pis']);
  
  // Addding some metadata from the filter like categories, range, etc.
  $res['metadata'] = ChartUtils::addFilterData($res, $rawData['filter']);
  return json_encode($res);
}



/**
 * Helper that gets raw mongo data and converts it to a format suitable for the chart
 *
 * @param raw_data
 * @return converted data
 */
function getAgeChartData($rawData) {
  $res = array();
  $res['age'] = ChartUtils::convertDataForKeys(array('u_18', 'b_18_24', 'b_25_34', 'b_35_54', 'o_55'), $rawData['data'], true);
  $res['metadata'] = ChartUtils::addFilterData($res, $rawData['filter']);
  return json_encode($res);
}

/**
 * Helper that gets raw mongo data and converts it to a format suitable for the chart
 *
 * @param raw_data
 * @return converted data
 */
function getGenderChartData($rawData) {
  $res = array();
  $res['gender'] = ChartUtils::convertDataForKeys(array('m', 'f', 'u'), $rawData['data']);
  $res['metadata'] = ChartUtils::addFilterData($res, $rawData['filter']);
  return json_encode($res);
}

/**
 * Helper that gets raw mongo data and converts it to a format suitable for the chart
 *
 * @param raw_data
 * @return converted data
 */
function getRelationshipChartData($rawData) {
  $res = array();
  $res['rel'] = ChartUtils::convertDataForKeys(array('singl', 'eng', 'compl', 'mar', 'rel', 'ior', 'wid', 'u'), $rawData['data']);
  $res['metadata'] = ChartUtils::addFilterData($res, $rawData['filter']);
  return json_encode($res);
}

/**
 * helper that gets raw mongo data and converts it to a format suitable for the chart
 *
 * @param raw_data
 * @return converted data
 */
function getMediaPenetrationChartData($rawData) {
  $res = array();
  $services = array('facebook', 'twitter', 'linkedin', 'google');
  $res['clickbacks'] = array();
  
  // Initializing the Data arrays for the chart
  foreach ($services as $service) {
    $res[$service.'_contacts'] = array();
  }
  
  // Sort data by date
  $rawData['data'] = ChartUtils::sortArrayByDate($rawData['data']);

  // Converting data into a chart usable format
  foreach ($rawData['data'] as $data) {
    $cb = 0;
    foreach ($services as $service) {
      if(array_key_exists($service, $data)) {
        array_push($res[$service.'_contacts'], $data[$service]['contacts']);
        $cb += $data[$service]['clickbacks'];
      } else {
        array_push($res[$service.'_contacts'], 0);        
      }
    }    
    array_push($res['clickbacks'], $cb);
  }
  
  // Get pi data by date
  $res['pis'] = ChartUtils::getPiData($rawData['pis']);

  $res['metadata'] = ChartUtils::addFilterData($res, $rawData['filter']);
  return json_encode($res);
}
