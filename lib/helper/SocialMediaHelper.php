<?php
/**
 * a social media helper
 *
 * @author Matthias Pfefferle
 */

/**
 * returns shares on twitter
 *
 * @param string $url
 * @return int
 */
function twitter_count($url) {
  $twitter_data = UrlUtils::getUrlContent("http://urls.api.twitter.com/1/urls/count.json?url=".urlencode($url));
	
  if($twitter_data = json_decode($twitter_data, true)) {
    return intval($twitter_data['count']);
  }
	
	return intval(0);
}

/**
 * returns shares on facebook
 *
 * @param string $url
 * @return string
 */
function facebook_count($url) {
  $facebook_data = UrlUtils::getUrlContent("http://graph.facebook.com/?ids=".urlencode($url));
	
  if($facebook_data = json_decode($facebook_data, true)) {
    if (array_key_exists($url, $facebook_data) && array_key_exists('shares', $facebook_data[$url])) {
      return intval($facebook_data[$url]['shares']);
    }
  }

  return intval(0);
}