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
  	$lHtml = UrlUtils::getUrlContent($pUrl, 'GET');

    $lOpenGraph = OpenGraph::parse($lHtml);
    $lToSave = array();

    if($lOpenGraph) {
      $lKeys["title"] = $lOpenGraph->__get('title');
      $lKeys["image"] = $lOpenGraph->__get('image');
      $lKeys["description"] = $lOpenGraph->__get('description');
    } else {
      $lKeys = MetaTagParser::getKeys($lHtml);
      $lKeys['image'] = null;
    }

    $lToSave['title'] = $lKeys["title"];
    $lToSave['image'] = $lKeys["image"];
    $lToSave['description'] = $lKeys["description"];
    return $lToSave;
  }

  public static function saveToArray($pArray) {
  	$lMeta = self::fetch($pArray['url']);
  	if(!$pArray['description'] || $pArray['description'] == null) {
  	 $pArray['description'] = $lMeta['description'];
  	}
    if(!$pArray['title'] || $pArray['title'] == null) {
     $pArray['title'] = $lMeta['title'];
    }
    if(!$pArray['image'] || $pArray['image'] == null) {
     $pArray['image'] = $lMeta['image'];
    }
    return $pArray;
  }
}