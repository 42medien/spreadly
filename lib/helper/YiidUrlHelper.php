<?php
sfProjectConfiguration::getActive()->loadHelpers('Url', 'Text');
/**
 * a helper to link between different apps
 *
 * @author Matthias Pfefferle
 */

function range_sensitive_link_to($name, $uri, $options = array()) {
  $request = sfContext::getInstance()->getRequest();
  $query_string = array();

  if ($param = $request->getParameter("date-selector")) {
    $query_string[] = "date-selector=".$param;
  }

  if ($param = $request->getParameter("date-to")) {
    $query_string[] = "date-to=".$param;
  }

  if ($param = $request->getParameter("date-from")) {
    $query_string[] = "date-from=".$param;
  }

  if ($query_string && array_key_exists('query_string', $options)) {
    $options['query_string'] .= "&".implode("&", $query_string);
  } else {
    $options['query_string'] = implode("&", $query_string);
  }

  return link_to($name, $uri, $options);
}

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

/**
 * auto links a url
 *
 * @param string $text_or_link
 * @param int $truncate_after
 * @param array $options
 */
function auto_link_to($text_or_link, $truncate_after = null, $options = array()) {
  if (UrlUtils::isUrlValid($text_or_link)) {
    echo link_to($text_or_link, truncate_text($text_or_link, $truncate_after), $options);
  } else {
    echo $text_or_link;
  }
}
?>