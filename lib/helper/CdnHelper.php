<?php

/**
 * load all stylesheets defined in our view.yml, makes use of include_javascript() deprecated
 *
 * @author Christian Weyand
 * @return string (HTML)
 */
function include_cdn_stylesheets() {
  $html = '';
  $response = sfContext::getInstance()->getResponse();

  foreach ($response->getStylesheets() as $css => $options)
  {
    $response->removeStylesheet($css);
    if (false === strpos(basename($css), '.css'))
    {
      $css .= '.css';
    }

    $html .= cdn_stylesheet_tag(ltrim($css, '/'), $options). "\r\n";
  }
  echo $html;
}


/**
 * load all javascripts defined in our view.yml, makes use of include_javascript() deprecated
 *
 * @author Christian Weyand
 * @return string (HTML)
 */
function include_cdn_javascripts() {
  $html = '';
  $response = sfContext::getInstance()->getResponse();

  foreach ($response->getJavascripts() as $js => $options)
  {
    $response->removeJavascript($js);
    if (false === strpos(basename($js), '.js'))
    {
      $js .= '.js';
    }
    $html .= cdn_javascript_tag(ltrim($js, '/'), $options). "\r\n";
  }
  echo $html;
}


/**
 * Generates a HTML Script include Tag, refering to our amazon bucket
 *
 * @author Christian Weyand
 * @param string $pFilename
 * @param array() $pOptions
 * @return unknown_type
 */
function cdn_javascript_tag($pFilename, $pOptions = array()) {
  if (sfConfig::get("sf_environment") != "dev") {
    $pFilename = concatNameWithRevision($pFilename, 'css');
  }

  return javascript_include_tag($pFilename, $pOptions);
}


/**
 * Generates a HTML CSS Tag, refering to our amazon bucketde
 *
 * @author Christian Weyand
 * @param string $pFilename
 * @param array() $pOptions
 * @return unknown_type
 */
function cdn_stylesheet_tag($pFilename, $pOptions = array()) {
  if (sfConfig::get("sf_environment") != "dev") {
    $pFilename = concatNameWithRevision($pFilename, 'css');
  }

  return stylesheet_tag( $pFilename, $pOptions);
}


/**
 *
 * generates path to image inside amazon s3 storage
 * i.e. img/ajax-loader.gif
 *
 * @param string $pFilename
 * @param array $pOptions
 */
function cdn_image_tag($pFilename, $pOptions = array()) {
  return image_tag( concatNameForStaticImages($pFilename), $pOptions);
}


/**
 * generates url to file on CloudFront CDN, respects Revision and gzip support by client
 *
 * @author Christian Weyand
 * @param  string $pFilename
 * @param string $pType  (css|js)
 * @return string
 */
function concatNameWithRevision($pFilename, $pType) {
  $lHost = '';
  $lHostname = CdnSingleton::getInstance()->getNextHost();
  $lHostname .= '/' . sfConfig::get('app_release_name') ;

  $lHost .= $lHostname .'/'.  $pType . '/' . $pFilename . CdnSingleton::getInstance()->isGzipped();
  return $lHost;
}

/**
 * generates url to file on CloudFront CDN, respects Revision and gzip support by client
 *
 * @author Christian Weyand
 * @param  string $pFilename
 * @param string $pType  (css|js)
 * @return string
 */
function concatNameForStaticImages($pFilename) {
  $lHost = '';
  $lHostname = CdnSingleton::getInstance()->getNextHost();
  $lHostname .= '/' . sfConfig::get('app_release_name');

  $lHost .= $lHostname . '/'. $pFilename;
  return $lHost;
}