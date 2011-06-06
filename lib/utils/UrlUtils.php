<?php
require_once(dirname(__FILE__).'./../vendor/idna_convert_080/idna_convert.class.php');

/**
 * class to handel url functions
 *
 * @author Matthias Pfefferle
 */
class UrlUtils {
  const HTTP_HEAD = 'HEAD';
  const HTTP_GET  = 'GET';
  const HTTP_POST = 'POST';

  /**
   * Default options for curl.
   */
  public static $CURL_OPTS = array(
    CURLOPT_CONNECTTIMEOUT => 10,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_TIMEOUT => 60,
    CURLOPT_USERAGENT => 'yiid-yak',
  );

  /**
   * check if URL is available
   * if an error 405 is thrown with HTTP_HEAD, try another time with HTTP_GET (i.e. http://www.panoramio.com/)
   *
   * @param string $pUrl URL
   * @return boolean
   */
  public static function checkUrlAvailability($pUrl) {
    // add idn support
    $IDN = new idna_convert(array('idn_version' => 2008));
    $pUrl = $IDN->encode($pUrl);

    try {
      $lHeaders = @get_headers($pUrl);

      if ($lHeaders === false) {
        return false;
      }

      if (preg_match('/HTTP\/1\.?[0-9]?\s+([0-9]+)/i', $lHeaders[0], $lStatus)) {
        $lStatus = $lStatus[1];
      }

      if ($lStatus < 400) {
        return true;
      } elseif ($lStatus == 405) {
        return self::checkUrlWithCurl($pUrl);
      } else {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
    // last but not least..
    return false;
  }

  /**
   * Check HTTP Status codes with CURL
   * @author Christian Weyand
   * @param $pUrl
   * @return boolean
   */
  public static function checkUrlWithCurl($pUrl, $pFollowLocation = false) {
    // add idn support
    $IDN = new idna_convert(array('idn_version' => 2008));
    $pUrl = $IDN->encode($pUrl);

    $ch = curl_init( $pUrl );
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_NOBODY, 1);
    if ($pFollowLocation) {
      curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    }
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.2) Gecko/20090803 Ubuntu/9.04 (jaunty) Shiretoko/3.5.2");
    curl_exec($ch);

    $lStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    if ($lStatus < 400) {
      return true;
    }
    else {
      return false;
    }
  }

  /**
   * read source code of an external website
   *
   * @param string $pUrl URL
   * @param string $pHttpMethod
   * @param string $pData
   * @param array $pHeader
   * @return string
   * @throws HttpException
   */
  public static function getUrlContent($pUrl, $pHttpMethod = self::HTTP_GET, $pData = null, $pHeader = null) {
    try {
      $lCh = curl_init();

      // add idn support
      $IDN = new idna_convert(array('idn_version' => 2008));
      $pUrl = $IDN->encode($pUrl);

      $lOpts = self::$CURL_OPTS;
      $lOpts[CURLOPT_URL] = $pUrl;
      curl_setopt_array($lCh, $lOpts);
      curl_setopt($lCh, CURLOPT_SSL_VERIFYPEER, false);
      curl_setopt($lCh, CURLOPT_SSL_VERIFYHOST, 2);
      curl_setopt($lCh, CURLOPT_FOLLOWLOCATION, 1);
      curl_setopt($lCh, CURLOPT_USERAGENT, "Mozilla/5.0 (X11; U; Linux i686; en-US; rv:1.9.1.2) Gecko/20090803 Ubuntu/9.04 (jaunty) Shiretoko/3.5.2");

      if ($pHttpMethod == self::HTTP_POST) {
        curl_setopt($lCh, CURLOPT_POST, 1);
        curl_setopt($lCh, CURLOPT_POSTFIELDS, $pData);
      }

      // checks if a http header is needed
      if ($pHeader) {
        curl_setopt($lCh, CURLOPT_HTTPHEADER, $pHeader);
      }

      $lContent = curl_exec( $lCh );
      $lStatus  = curl_getinfo( $lCh, CURLINFO_HTTP_CODE );
      curl_close( $lCh );

      if ($lStatus < 400) {
        return $lContent;
      } else {
        throw new HttpException("Error while parsing the website", 401);
      }

    } catch (Exception $e) {
      throw new HttpException("Error while parsing the website", $e->getCode());
    }
  }

  /**
   * returns the favicon of an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function getFavicon ($pUrl) {
    return "http://www.google.com/s2/favicons?domain_url=".$pUrl;
  }

  /**
   * Returns domain with top-level-domain
   * use libary: http://tobyinkster.co.uk/blog/2007/07/19/php-domain-class/
   * use libary: http://mxr.mozilla.org/mozilla-central/source/netwerk/dns/src/effective_tld_names.dat?raw=1%27);
   * @param string $pUrl
   * @return string
   */
  public static function getDomainAsArray($pUrl) {
    // add idn support
    $IDN = new idna_convert(array('idn_version' => 2008));
    $pUrl = $IDN->encode($pUrl);

    $lUrl =  strtolower($pUrl);
    $arrUrl = parse_url($lUrl);
    if(!isset($arrUrl['scheme'])){
      $lUrl = 'http://'.$lUrl;
    }

    $lDomain = array();
    $lObjDomain = Domain::from_url($pUrl);
    $lDomain['domain'] = $lObjDomain->get_reg_domain();
    $lDomain['toplevel'] = $lObjDomain->get_etld();

    $count = strlen($lDomain['domain']);
    $lLastChar = $lDomain['domain']{$count-1};
    if ($lLastChar == '.') {
      $lDomain['domain'] = substr($lDomain['domain'], 0, $count-1);
    }

    $countTl = strlen($lDomain['toplevel']);
    $lLastCharTl = $lDomain['toplevel']{$countTl-1};
    if ($lLastCharTl == '.') {
      $lDomain['toplevel'] = substr($lDomain['toplevel'], 0, $countTl-1);
    }

    return $lDomain;
  }

  /**
   * url validator
   *
   * @param string $pUrl
   * @return boolean
   */
  public static function isUrlValid($pUrl) {
    $lPattern = '~^
        (https?|ftps?)://                       # http or ftp (+SSL)
        (
          ([a-z0-9äöüß-]+\.)+[a-z]{2,6}             # a domain name
            |                                   #  or
          \d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}    # a IP address
        )
        (:[0-9]+)?                              # a port (optional)
        (/?|\?\S+|/\S+)                         # a /, nothing or a / with something
      $~ix';

    return preg_match($lPattern, (string)$pUrl);
  }

  /**
   * extract the host from an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function getHost($pUrl) {
    $lHost = parse_url($pUrl, PHP_URL_HOST);
    $lParts = explode(".", $lHost);

    return $lParts[count($lParts)-2].".".$lParts[count($lParts)-1];
  }

  /**
   * extract the host from an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function getFullHost($pUrl) {
    $lHost = parse_url($pUrl, PHP_URL_HOST);
    $lParts = explode(".", $lHost);

    if (count($lParts) > 3 || count($lParts) == 2) {
      return $lHost;
    } else {
      if ($lParts[count($lParts)-3] == "www") {
        return $lParts[count($lParts)-2].".".$lParts[count($lParts)-1];
      } else {
        return $lHost;
      }
    }
  }

  /**
   * build the short url of an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function getShortUrl($pUrl) {
    $lScheme = parse_url($pUrl, PHP_URL_SCHEME);
    $lHost = parse_url($pUrl, PHP_URL_HOST);
    $lValue = $lScheme.'://'.$lHost;
    return $lValue;
  }

  /**
   * returns full host without www
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return string
   */
  public static function getNormalizedHost($pUrl) {
    $lHost = parse_url($pUrl, PHP_URL_HOST);

    return $lUrl = str_replace('www.', '', $lHost);
  }

  /**
   * extract the domain from an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function getDomain($pUrl) {
    $lHost = parse_url($pUrl, PHP_URL_HOST);
    $lParts = explode(".", $lHost);

    return $lParts[count($lParts)-2];
  }

  /**
   * normalize an url
   *
   * @param string $pUrl
   * @return string
   */
  public static function normalizeUrl($pUrl) {
    $lUrl = str_replace('http://', '', $pUrl);
    $lUrl = str_replace('https://', '', $lUrl);
    $lUrl = str_replace('www.', '', $lUrl);

    if ('/' == substr($lUrl, strlen($lUrl)-1)) $lUrl = substr_replace($lUrl, '', strlen($lUrl)-1);  // strip trailing slash

    return $lUrl;
  }

  /**
   * attaches an array of get parameters to a url, only attaches the parameters if they havent been set yet.
   *
   * @param String $pUrl the url to append the parameter to
   * @param Array $pParam an array with key/value pairs of
   * @param Boolean not implemented yet, replace old params if already there
   * @return String the new url
   */
  public static function addUrlParams($pUrl, $pParams, $pReplace = false){
    $lNewUrl = $pUrl;
    foreach($pParams as $lKey => $lVal){
      $lSearchStr = $lKey."=";

      //if not present in string yet
      if(!strpos($lNewUrl, $lSearchStr)){
        if(stristr($lNewUrl, '?') === false){
          $lNewUrl.='?';
        } else {
          $lNewUrl.='&';
        }
        $lNewUrl .= $lKey."=".$lVal;
      } elseif ($pReplace) {
        $lSplit = explode("?", $lNewUrl);
        $lParams = explode("&", $lSplit[1]);

        $lNewArray = array();
        foreach ($lParams as $lEntry) {
          if (strpos($lEntry, $lSearchStr) !== false) {
            $lEntry = $lKey."=".$lVal;
          }

          $lNewArray[] = $lEntry;
        }

        $lNewUrl = $lSplit[0]."?".implode("&", $lNewArray);
      }
    }
    return $lNewUrl;
  }

  /**
   * This function parses the transfered url and returns the meta tags
   *
   * @param string $pUrl
   * @return array
   */
  public static function parseUrlMetaTags($pUrl) {
    $lMetaTags = get_meta_tags($pUrl);
    $lCharset = self::getUrlCharset($pUrl);

    $lMetaArray = array();
    $lDataFound = false;

    // title
    if($lMetaTags['title'] != '') {
      if($lCharset == 'iso') {
        $lMetaArray['title'] = utf8_encode(html_entity_decode($lMetaTags['title']));
      } else {
        $lMetaArray['title'] = html_entity_decode($lMetaTags['title']);
      }
      $lDataFound = true;
    } elseif($lMetaTags['dc_title'] != '') {
      if($lCharset == 'iso') {
        $lMetaArray['title'] = utf8_encode(html_entity_decode($lMetaTags['dc_title']));
      } else {
        $lMetaArray['title'] = html_entity_decode($lMetaTags['dc_title']);
      }
      $lDataFound = true;
    } else {
      // parse website for title
      $lUrlContent = self::getUrlContent($pUrl);
      $lPattern = "|<[\s]*title[\s]*>([^<]+)<[\s]*/[\s]*title[\s]*>|Ui";
      if(preg_match($lPattern, $lUrlContent, $lMatch)) {
        if($lCharset == 'iso') {
          $lMetaArray['title'] = utf8_encode(html_entity_decode($lMatch[1]));
        } else {
          $lMetaArray['title'] = html_entity_decode($lMatch[1]);
        }
        $lDataFound = true;
      }
    }

    // if title is set, shorten
    if($lMetaArray['title'] != '') {
      $lMetaArray['title'] = substr($lMetaArray['title'], 0, 49);
    }

    // description
    if($lMetaTags['description'] != '') {
      if($lCharset == 'iso') {
        $lMetaArray['description'] = utf8_encode(html_entity_decode($lMetaTags['description']));
      } else {
        $lMetaArray['description'] = html_entity_decode($lMetaTags['description']);
      }
      $lDataFound = true;
    }

    // keywords
    if($lMetaTags['keywords'] != '') {
      if($lCharset == 'iso') {
        $lMetaArray['keywords'] = utf8_encode(html_entity_decode($lMetaTags['keywords']));
      } else {
        $lMetaArray['keywords'] = html_entity_decode($lMetaTags['keywords']);
      }
      $lDataFound = true;
    }

    // language
    if($lMetaTags['language'] != '') {
      $lMetaArray['language'] = $lMetaTags['language'];
      $lDataFound = true;
    }

    // author
    if($lMetaTags['author'] != '') {
      if($lCharset == 'iso') {
        $lMetaArray['author'] = utf8_encode(html_entity_decode($lMetaTags['author']));
      } else {
        $lMetaArray['author'] = html_entity_decode($lMetaTags['author']);
      }
      //$lDataFound = true;
    }

    // take url as source, but only if some data was found
    if($lDataFound) {
      $lMetaArray['source'] = $pUrl;
      $lMetaArray['data_found'] = true;
    } else {
      $lMetaArray['data_found'] = false;
    }

    return $lMetaArray;
  }

  /**
   * This function returns the charset of the transfered url
   *
   * @author Christian Schätzle
   *
   * @param string $pUrl
   * @return string
   */
  public static function getUrlCharset($pUrl) {
    $lUrlContent = self::getUrlContent($pUrl);

    $lReturnValue = 'utf';

    $lPattern = '/Content-Type\s*[^;]*;\s*charset\s*=\s*"?((?:"[^"]*")|(?:[^"\s]*))"?/';

    if(preg_match($lPattern, $lUrlContent, $lMatches)) {
      if($lMatches[1] != '') {
        $lCharset = $lMatches[1];

        $lUtfPattern = '{utf}i';
        $lIsoPattern = '{iso}i';

        if(preg_match($lUtfPattern, $lCharset)) {
          $lReturnValue = 'utf';
        } elseif(preg_match($lIsoPattern, $lCharset)) {
          $lReturnValue = 'iso';
        }
      }
    }

    return $lReturnValue;
  }

  /**
   * function to expand for example short urls
   *
   * @author Matthias Pfefferle
   * @param string $pUrl must be a valid url
   * @return string the expanded url
   */
  public static function shortUrlExpander($pUrl) {
    if (!self::checkUrlAvailability($pUrl)) {
      return false;
    }
    return self::get_final_url($pUrl);
  }

  /**
   * get_redirect_url()
   * Gets the address that the provided URL redirects to,
   * or FALSE if there's no redirect.
   *
   * @param string $url
   * @return string
   */
  public static function get_redirect_url($url){
    $redirect_url = null;

    $url_parts = @parse_url($url);
    if (!$url_parts) return false;
    if (!isset($url_parts['host'])) return false; //can't process relative URLs
    if (!isset($url_parts['path'])) $url_parts['path'] = '/';

    $sock = @fsockopen($url_parts['host'], (isset($url_parts['port']) ? (int)$url_parts['port'] : 80), $errno, $errstr, 30);
    if (!$sock) return false;

    $request = "HEAD " . $url_parts['path'] . (isset($url_parts['query']) ? '?'.$url_parts['query'] : '') . " HTTP/1.1\r\n";
    $request .= 'Host: ' . $url_parts['host'] . "\r\n";
    $request .= 'User-Agent:  YIID/0.2 (Url Parser; http://www.yiid.it/; Allow like Gecko)'. "\r\n";
    $request .= "Connection: Close\r\n\r\n";
    fwrite($sock, $request);
    $response = '';
    while(!feof($sock)) $response .= fread($sock, 8192);
    fclose($sock);

    if (preg_match('/^Location: (.+?)$/m', $response, $matches)){
      if ( substr($matches[1], 0, 1) == "/" )
      return $url_parts['scheme'] . "://" . $url_parts['host'] . trim($matches[1]);
      else
      return trim($matches[1]);

    } else {
      return false;
    }

  }

  /**
   * get_all_redirects()
   * Follows and collects all redirects, in order, for the given URL.
   *
   * @param string $url
   * @return array
   */
  public static function get_all_redirects($url){
    $redirects = array();
    while ($newurl = self::get_redirect_url($url)){
      if (in_array($newurl, $redirects)){
        break;
      }
      $redirects[] = $newurl;
      $url = $newurl;
    }
    return $redirects;
  }

  /**
   * get_final_url()
   * Gets the address that the URL ultimately leads to.
   * Returns $url itself if it isn't a redirect.
   *
   * @param string $url
   * @return string
   */
  public static function get_final_url($url){
    $redirects = self::get_all_redirects($url);
    if (count($redirects)>0){
      return array_pop($redirects);
    } else {
      return $url;
    }
  }

  /**
   * normalize URL and build an md5 hash
   *
   * @author Matthias Pfefferle
   * @param string $pUrl the url
   * @return string the normalized hash
   */
  public static function generateNormalizedUrlHash($pUrl) {
    $lUrl = str_replace('http://www.', 'http://', $pUrl);
    $lUrl = str_replace('https://www.', 'https://', $lUrl);

    $lUrl = self::skipTrailingSlash($lUrl);

    return md5($lUrl);
  }

  /**
   *
   * transforms http://weyands.net/ to http://weyands.net
   * @param string $pUrl
   * @return string
   */
  public static function skipTrailingSlash($pUrl) {
    if ('/' == substr($pUrl, strlen($pUrl)-1)) {
      $pUrl = substr_replace($pUrl, '', strlen($pUrl)-1);  // strip trailing slash
    }
    return $pUrl;
  }

  /**
   * function to send a GET request
   * curl provides a better ssl support
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return string
   */
  public static function sendGetRequest($pUrl, $pHeader = null) {
    // add idn support
    $IDN = new idna_convert(array('idn_version' => 2008));
    $pUrl = $IDN->encode($pUrl);

    $lCh = curl_init();
    $lOpts = self::$CURL_OPTS;
    $lOpts[CURLOPT_URL] = $pUrl;
    curl_setopt_array($lCh, $lOpts);
    curl_setopt($lCh, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($lCh, CURLOPT_SSL_VERIFYHOST, 2);

    if ($pHeader) {
      curl_setopt($lCh, CURLOPT_HTTPHEADER,   $pHeader);
    }

    $lResponse = curl_exec($lCh);

    return $lResponse;
  }

  /**
   * better post function used for oauth
   *
   * @param string $pUrl
   * @param string $pBody
   */
  public static function sendPostRequest($pUrl, $pBody, $pHeader = null) {
    // add idn support
    $IDN = new idna_convert(array('idn_version' => 2008));
    $pUrl = $IDN->encode($pUrl);

    $lCh = curl_init($pUrl);
    curl_setopt($lCh, CURLOPT_POST,           1);
    curl_setopt($lCh, CURLOPT_POSTFIELDS,     $pBody);
    curl_setopt($lCh, CURLOPT_FOLLOWLOCATION, 1);
    curl_setopt($lCh, CURLOPT_HEADER,         0);  // DO NOT RETURN HTTP HEADERS
    curl_setopt($lCh, CURLOPT_RETURNTRANSFER, 1);  // RETURN THE CONTENTS OF THE CALL
    curl_setopt($lCh, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($lCh, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($lCh, CURLOPT_VERBOSE,        1);

    if ($pHeader) {
      curl_setopt($lCh, CURLOPT_HTTPHEADER,   $pHeader);
    }

    $lResponse = curl_exec($lCh);

    return $lResponse;
  }

  /**
   * checks for existing resource records on a given URL
   *
   * @author Christian Weyand
   * @param $pUrl
   * @return unknown_type
   */
  public static function hasExistingDnsRecords($pUrl) {
    return self::isUrlValid($pUrl) && (sfConfig::get('app_check_url_pass', 1) || checkdnsrr($pUrl, 'A') || checkdnsrr($pUrl, 'AAAA'));
  }

  /**
   * removes unwanted GET-Parameters and strips #anchors
   *
   * @author Christian Weyand
   * @param $pUrl
   * @return unknown_type
   */
  public static function cleanupHostAndUri($pUrl) {
    $pUrl = urldecode($pUrl);
    $pUrl = str_replace(" ", "+", $pUrl);
    //$pUrl = self::skipTrailingSlash($pUrl);
    $parameterList = parse_url($pUrl);
    $pQueryString = '';
    $lKeysToRemove = sfConfig::get('app_settings_filtered_parameters');
    if (isset($parameterList['path'])) {
      $pQueryString .= $parameterList['path'];
    }
    if (isset($parameterList['query'])) {
      $lGetParams = array();
      parse_str($parameterList['query'], $lGetParams);
      $parameterList['params'] = array_diff_key($lGetParams, array_fill_keys($lKeysToRemove, 0));
      $pQueryString .= (!empty($parameterList['params']))?'?'.http_build_query($parameterList['params']):'';
    }
    return $parameterList['scheme'].'://'.$parameterList['host'].$pQueryString;
  }

  /**
   * generates an absolute url out of url-parts
   *
   * @author Matthias Pfefferle
   *
   * @param string $part
   * @param string $url
   * @return string
   */
  public static function abslink($part, $url) {
    // check if url is still absolute
    if (preg_match('~^https?:\/\/~i', $part)) {
      return $part;
    }

    // check if url removed protocol for better https support
    if (preg_match('~^\/\/~i', $part)) {
      return parse_url($url,PHP_URL_SCHEME).":".$part;
    }

    // generate absolute url
    $url = parse_url($url,PHP_URL_SCHEME)."://".parse_url($url,PHP_URL_HOST);

    $file_path = parse_url($part,PHP_URL_PATH);
    $file_path = substr($file_path,0,1) == '/' ? $file_path : '/' . $file_path;

    return $url . $file_path;
  }
}