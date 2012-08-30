<?php
sfProjectConfiguration::getActive()->loadHelpers('Asset');

/**
 * returns a favicon image tag
 *
 * @param string $pUrl
 * @param array $pParams
 * @return string
 */
function favicon_tag($pUrl, array $pParams = array()) {
  $lOptions = _parse_attributes($pParams);

  if(!isset($lOptions['alt'])) {
    $lOptions['alt'] = 'favicon';
  }

  if(!isset($lOptions['class'])) {
    $lOptions['class'] = 'favicon';
  } else {
    $lOptions['class'] = $lOptions['class'] . ' favicon';
  }

  return image_tag(UrlUtils::getFavicon($pUrl), $lOptions);
}


function favicon_byslug_tag($pSlug, array $pParams = array()) {
  $lOptions = _parse_attributes($pParams);

  if(!isset($lOptions['alt'])) {
    $lOptions['alt'] = $pSlug;
  }

  if(!isset($lOptions['class'])) {
    $lOptions['class'] = 'favicon';
  } else {
    $lOptions['class'] = $lOptions['class'] . ' favicon';
  }

  return image_tag('/uploads/favicons/'.$pSlug.'.png', $lOptions);
}

/**
 * returns the url of a favicon
 *
 * @param string $pUrl
 * @return string
 */
function get_favicon($pUrl) {
  return UrlUtils::getFavicon($pUrl);
}
?>
