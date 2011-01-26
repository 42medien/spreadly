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
  //$res['age'] = ChartUtils::convertDataForKeys(array('u_18', 'b_18_24', 'b_25_34', 'b_35_54', 'o_55'), $rawData['data'], true);
  $res['age'] = $rawData['total']['age'];
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


function getChartLineActivitiesData($rawData, $community='all') {
  $res = array();
  $services = array('facebook', 'twitter', 'linkedin', 'google');

  $res['likes'] = array();
  $res['dislikes'] = array();

  $temp = ChartUtils::getActivitiesForAllServices($rawData, $services);

  for ($i=0; $i < count($temp['facebook_likes']); $i++) {

    $res['likes'][$i] = 0;
    if($community=='all') {
      $res['likes'][$i] += $temp['facebook_likes'][$i] +
                           $temp['twitter_likes'][$i] +
                           $temp['linkedin_likes'][$i] +
                           $temp['google_likes'][$i];
    } else {
      $res['likes'][$i] += $temp[$community.'_likes'][$i];
    }

    $res['dislikes'][$i] = 0;
    if($community=='all') {
      $res['dislikes'][$i] += $temp['facebook_dislikes'][$i] +
                              $temp['twitter_dislikes'][$i] +
                              $temp['linkedin_dislikes'][$i] +
                              $temp['google_dislikes'][$i];
    } else {
      $res['dislikes'][$i] += $temp[$community.'_dislikes'][$i];
    }
  }

  // Addding some metadata from the filter like categories, range, etc.
  $metadata = ChartUtils::addFilterData($res, $rawData['filter']);

  $res['startdate'] = $metadata['startdate'];

  return json_encode($res);
}

function getChartLineActivitiesDataAsArray($rawData, $community='all') {
  $res = array();
  $services = array('facebook', 'twitter', 'linkedin', 'google');

  $res['likes'] = array();
  $res['dislikes'] = array();

  $temp = ChartUtils::getActivitiesForAllServices($rawData, $services);

  for ($i=0; $i < count($temp['facebook_likes']); $i++) {

    $res['likes'][$i] = 0;
    if($community=='all') {
      $res['likes'][$i] += $temp['facebook_likes'][$i] +
                           $temp['twitter_likes'][$i] +
                           $temp['linkedin_likes'][$i] +
                           $temp['google_likes'][$i];
    } else {
      $res['likes'][$i] += $temp[$community.'_likes'][$i];
    }

    $res['dislikes'][$i] = 0;
    if($community=='all') {
      $res['dislikes'][$i] += $temp['facebook_dislikes'][$i] +
                              $temp['twitter_dislikes'][$i] +
                              $temp['linkedin_dislikes'][$i] +
                              $temp['google_dislikes'][$i];
    } else {
      $res['dislikes'][$i] += $temp[$community.'_dislikes'][$i];
    }
  }

  // Addding some metadata from the filter like categories, range, etc.
  $metadata = ChartUtils::addFilterData($res, $rawData['filter']);

  $res['startdate'] = $metadata['startdate'];

  return $res;
}

function getChartLineRangeViewsData($rawData, $community='all') {
  $res = array();
  $services = array('facebook', 'twitter', 'linkedin', 'google');
  $res['clickbacks'] = array();
  $res['views'] = array();

  $temp = array();
  // Initializing the Data arrays for the chart
  foreach ($services as $service) {
    $temp[$service.'_contacts'] = array();
    $temp[$service.'_clickbacks'] = array();
  }

  // Sort data by date
  $rawData['data'] = ChartUtils::sortArrayByDate($rawData['data']);

  // Converting data into a chart usable format
  foreach ($rawData['data'] as $data) {
    $cb = 0;
    foreach ($services as $service) {
      if(array_key_exists($service, $data)) {
        array_push($temp[$service.'_contacts'], $data[$service]['contacts']);
        array_push($temp[$service.'_clickbacks'], $data[$service]['clickbacks']);
        $cb += $data[$service]['clickbacks'];
      } else {
        array_push($temp[$service.'_contacts'], 0);
        array_push($temp[$service.'_clickbacks'], 0);
      }
    }
    //array_push($res['clickbacks'], $cb);
  }

  for ($i=0; $i < count($temp['facebook_contacts']); $i++) {

    $res['views'][$i] = 0;
    if($community=='all') {
      $res['views'][$i] += $temp['facebook_contacts'][$i] +
                           $temp['twitter_contacts'][$i] +
                           $temp['google_contacts'][$i] +
                           $temp['linkedin_contacts'][$i];
    } else {
      $res['views'][$i] += $temp[$community.'_contacts'][$i];
    }

    $res['clickbacks'][$i] = 0;
    if($community=='all') {
      $res['clickbacks'][$i] += $temp['facebook_clickbacks'][$i] +
                           $temp['twitter_clickbacks'][$i] +
                           $temp['google_clickbacks'][$i] +
                           $temp['linkedin_clickbacks'][$i];
    } else {
      $res['clickbacks'][$i] += $temp[$community.'_clickbacks'][$i];
    }
  }

  // Addding some metadata from the filter like categories, range, etc.
  $metadata = ChartUtils::addFilterData($res, $rawData['filter']);

  $res['startdate'] = $metadata['startdate'];

  return json_encode($res);
}

