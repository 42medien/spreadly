<?php
/**
 * a parser for social objects
 *
 * @author Matthias Pfefferle
 */
class SocialObjectParser {

  /**
   * Enter description here...
   *
   * @param string $pUrl
   */
  public static function fetch($pUrl) {
    $lResult = OpenGraph::fetch($pUrl);


    var_dump(get_meta_tags($pUrl));

    var_dump($lResult);
  }
}