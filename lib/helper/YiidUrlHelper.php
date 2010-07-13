<?php
sfProjectConfiguration::getActive()->loadHelpers('Url');
/**
 * a helper to link between different apps
 *
 * @author Matthias Pfefferle
 */

/**
 * helper to set links for the yiid app
 *
 * @param string $name the linkname: <a href="">LINKNAME</a>
 * @param string $username the username: http://USERNAME.yiid.com
 * @param string $internal_uri model/action combi: http://xxx.yiid.com/MODULE/ACTION
 * @param array $options
 * @return string a html formatted link
 */
function link_to_yiid($name, $username, $internal_uri = null, $options = array()) {
  $uri = str_replace('%user%', $username, sfConfig::get('app_settings_yiid'));
  if ($internal_uri) {
    $uri = $uri."/".$internal_uri;
  }
  return link_to($name, $uri, $options);
}

/**
 * helper to build an URI for the yiid app
 *
 * @param string $username the username: http://USERNAME.yiid.com
 * @param string $internal_uri model/action combi: http://xxx.yiid.com/MODULE/ACTION
 * @param string $absolute
 * @return string an URI
 */
function url_for_yiid($username, $internal_uri = null, $absolute = false) {
  $uri = str_replace('%user%', $username, sfConfig::get('app_settings_yiid'));
  if ($internal_uri) {
    $uri = $uri."/".$internal_uri;
  }
  return url_for($uri, $absolute);
}

/**
 * helper to build an URI for the frontend app
 *
 * @param string $internal_uri model/action combi: http://www.yiid.com/MODULE/ACTION
 * @param string $absolute
 * @return string an URI
 */
function url_for_frontend($internal_uri, $absolute = false) {
  $uri = sfConfig::get('app_settings_url')."/".$internal_uri;
  return url_for($uri, $absolute);
}

/**
 * helper to set links for the yiid app
 *
 * @param string $name the linkname: <a href="">LINKNAME</a>
 * @param string $internal_uri model/action combi: http://www.yiid.com/MODULE/ACTION
 * @param array $options
 * @return string a html formatted link
 */
function link_to_frontend($name, $internal_uri, $options = array()) {
  $uri = sfConfig::get('app_settings_url').url_for($internal_uri);
  return link_to($name, $uri, $options);
}

/**
 * helper to set short urls
 *
 * @param string $name the linkname: <a href="">LINKNAME</a>
 * @param string $id for example cope#User#1
 * @param array $options
 * @return string a html formatted link
 */
function shortlink_to($name, $id, $options = array()) {
  $lComponents = explode('#', $id);
  $uri = sfConfig::get('app_settings_short_url')."/".implode('/',$lComponents);
  return link_to($name, $uri, $options);
}

/**
 * helper to build an URI for the widgets app
 *
 * @param string $internal_uri model/action combi: http://widgets.yiid.com/MODULE/ACTION
 * @param boolean $absolute
 * @return string an URI
 */
function url_for_widgets($internal_uri, $absolute = true) {
  $uri = sfConfig::get('app_settings_widgets_url')."/".$internal_uri;
  return url_for($uri, $absolute);
}



?>