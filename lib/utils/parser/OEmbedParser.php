<?php
class OEmbedParser {
  public static function fetchByUrl($url) {

  }

  public static function fetchByCode($html) {
    $urls = self::discover($html);

    if ($urls) {
      if (array_key_exists('json', $urls)) {
        return self::request($urls['json'], 'json');
      } elseif (array_key_exists('xml', $urls)) {
        return self::request($urls['xml'], 'json');
      }
    }

    return false;
  }

  public static function discover($html) {
    $providers = array();

    // <link> types that contain oEmbed provider URLs
    $linktypes = array(
      'application/json+oembed' => 'json',
      'text/xml+oembed' => 'xml',
      'application/xml+oembed' => 'xml', // Incorrect, but used by at least Vimeo
    );

    // Do a quick check
    $tagfound = false;
    foreach ( $linktypes as $linktype => $format ) {
      if ( stripos($html, $linktype) ) {
        $tagfound = true;
        break;
      }
    }

    if ( $tagfound && preg_match_all( '/<link([^<>]+)>/i', $html, $links ) ) {
      foreach ( $links[1] as $link ) {
        $atts = self::parseAtts( $link );
        if ( !empty($atts['type']) && !empty($linktypes[$atts['type']]) && !empty($atts['href']) ) {
          $providers[$linktypes[$atts['type']]] = $atts['href'];
          // Stop here if it's JSON (that's all we need)
          if ( 'json' == $linktypes[$atts['type']] )
          break;
        }
      }
    }

    return $providers;
  }

  public static function parseAtts($text) {
    $atts = array();
    $pattern = '/(\w+)\s*=\s*"([^"]*)"(?:\s|$)|(\w+)\s*=\s*\'([^\']*)\'(?:\s|$)|(\w+)\s*=\s*([^\s\'"]+)(?:\s|$)|"([^"]*)"(?:\s|$)|(\S+)(?:\s|$)/';
    $text = preg_replace("/[\x{00a0}\x{200b}]+/u", " ", $text);
    if ( preg_match_all($pattern, $text, $match, PREG_SET_ORDER) ) {
      foreach ($match as $m) {
        if (!empty($m[1]))
        $atts[strtolower($m[1])] = stripcslashes($m[2]);
        elseif (!empty($m[3]))
        $atts[strtolower($m[3])] = stripcslashes($m[4]);
        elseif (!empty($m[5]))
        $atts[strtolower($m[5])] = stripcslashes($m[6]);
        elseif (isset($m[7]) and strlen($m[7]))
        $atts[] = stripcslashes($m[7]);
        elseif (isset($m[8]))
        $atts[] = stripcslashes($m[8]);
      }
    } else {
      $atts = ltrim($text);
    }
    return $atts;
  }

  /**
   * Enter description here...
   *
   * @param unknown_type $url
   * @return unknown
   */
  public static function request($url, $format) {
    $content = UrlUtils::getUrlContent($url);

    if ($format == "json") {
      $result = json_decode(trim($content), false);
      if (is_object($result)) {
        return $result;
      } else {
        return false;
      }
    } else {
      $result = simplexml_load_string(trim($content));
      if (is_object($result)) {
        return $result;
      }
    }

    return false;
  }
}