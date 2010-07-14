<?php


class ShortUrlTable extends Doctrine_Table
{
  /**
   * array to encode the db id
   */
  public static $chars = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z", "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
  /**
   * array to decode the tiny url
   */
  public static $nums = array(0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7, 8 => 8, 9 => 9, "a" => 10, "b" => 11, "c" => 12, "d" => 13, "e" => 14, "f" => 15, "g" => 16, "h" => 17, "i" => 18, "j" => 19, "k" => 20, "l" => 21, "m" => 22, "n" => 23, "o" => 24, "p" => 25, "q" => 26, "r" => 27, "s" => 28, "t" => 29, "u" => 30, "v" => 31, "w" => 32, "x" => 33, "y" => 34, "z" => 35, "A" => 36, "B" => 37, "C" => 38, "D" => 39, "E" => 40, "F" => 41, "G" => 42, "H" => 43, "I" => 44, "J" => 45, "K" => 46, "L" => 47, "M" => 48, "N" => 49, "O" => 50, "P" => 51, "Q" => 52, "R" => 53, "S" => 54, "T" => 55, "U" => 56, "V" => 57, "W" => 58, "X" => 59, "Y" => 60, "Z" => 61);


  public static function getInstance()
  {
    return Doctrine_Core::getTable('ShortUrl');
  }

  /**
   * function to encode the database id to a short-url-string
   *
   * @param int $num The database number
   * @return string The encoded string for the short-url
   */
  public static function charize($num) {
    $returnstr = "";

    if ($num >= count(self::$chars)) {
      $tmp = (int)($num / count(self::$chars));
      $rest = $num - (count(self::$chars)*$tmp);
      $returnstr .= self::charize($tmp);
      $returnstr .= self::$chars[$rest];
      return $returnstr;
    } else {
      $returnstr .= self::$chars[$num];
      return $returnstr;
    }
  }

  /**
   * function to decode a short-url to a number
   *
   * @param string $text
   * @return int The database number
   */
  public static function uncharize($text) {
    $returnint = 0;
    if (strlen($text) > 1) {
      $tmp = substr($text,1);
      $tmp2 = substr($text,0,1);
      $returnint += self::uncharize($tmp);
      $returnint += pow((count(self::$nums)),(strlen($text)-1))*self::$nums[$tmp2];
      return $returnint;
    } else {
      $returnint += self::$nums[$text];
      return $returnint;
    }
  }


  /**
   * retrieve ShortUrl-object by Url
   *
   * @param string $pUrl
   * @return null|ShortUrl
   */
  public static function getByUrl($pUrl) {
    $lQ = Doctrine_Query::create()
    ->from('ShortUrl s')
    ->where('s.url = ?', $pUrl);

    return $lQ->fetchOne();
  }

  /**
   * retrieves recently shorted Entries
   *
   * @param int   $pLimit
   * @param boolean $pHideYiid
   */
  public static function getLatestUrls($pLimit = 5, $pHideYiid = true) {
    $lYiidHost = UrlUtils::getHost(sfConfig::get("app_settings_url"));

    $lQ = Doctrine_Query::create()
    ->from('ShortUrl s')
    ->orderBy('s.id DESC')
    ->limit($pLimit);

    if ($pHideYiid) {
      $lQ->where('s.url <> ?', $lYiidHost.'%');
    }

    return $lQ->execute();
  }

  /**
   * shortens a valid url and returns a short url
   *
   * @param   string $pUrl
   * @return  string
   * @throws  ModelException
   */
  public static function shortenUrl($pUrl) {
    $lUrl = urldecode($pUrl);

    if (!UrlUtils::isUrlValid($lUrl)) {
      throw new ModelException("invalid url");
    }

    if ($lShortUrl = self::getByUrl($lUrl)) {
      return $lShortUrl->getShortedUrl();
    } else {
      $lShortUrl = new ShortUrl();
      $lShortUrl->setUrl($lUrl);
      $lShortUrl->save();

      return $lShortUrl->getShortedUrl();
    }
  }


  /**
   * prepares the api-response for the short-url jaon output
   *
   * @author Matthias Pfefferle
   * @param string $pUrl
   * @return string json
   */
  public static function prepareApiResponse($pUrl) {
    try {
      $lResponse = array ("status" => array("result" => "OK", "code" => "200", "message" => "url was shorted"));
      $lResponse["url"] = urldecode($pUrl);
      $lResponse["shorturl"] = self::shortenUrl($pUrl);
      return json_encode($lResponse);
    } catch (Exception $e) {
      $lResponse = array ("status" => array("result" => "ERROR", "code" => "409", "message" => $e->getMessage()));
      return json_encode($lResponse);
    }
  }
}