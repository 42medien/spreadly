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
  	try {
	  	$lHtml = UrlUtils::getUrlContent($pUrl, 'GET');
	    $lOpenGraph = OpenGraph::parse($lHtml);
	    $lToSave = array();

	    if($lOpenGraph) {
	      $lKeys["title"] = $lOpenGraph->__get('title');
	      $lKeys["image"] = $lOpenGraph->__get('image');
	      $lKeys["description"] = $lOpenGraph->__get('description');
	    } else {
	      $lKeys = MetaTagParser::getKeys($lHtml);
	      $lKeys['title'] = (isset($lKeys['title']))?$lKeys['title']:null;
	      $lKeys['description'] = (isset($lKeys['description']))?$lKeys['description']:null;
	      $lKeys['image'] = null;
	    }
	    $lToSave['title'] = ($lKeys["title"])?$lKeys["title"]:'';
	    $lToSave['thumb_url'] = $lKeys["image"];
	    $lToSave['stmt'] = ($lKeys["description"])?$lKeys["description"]:'';
	    return $lToSave;
  	}catch (Exception $e) {

  	}
  }

  public static function saveToArray($pArray) {
  	$lMeta = self::fetch($pArray['url']);
  	if(!$pArray['stmt'] || $pArray['stmt'] == null) {
  	 $pArray['stmt'] = $lMeta['stmt'];
  	}
    if(!$pArray['title'] || $pArray['title'] == null) {
     $pArray['title'] = $lMeta['title'];
    }
    if(!$pArray['thumb_url'] || $pArray['thumb_url'] == null) {
     $pArray['thumb_url'] = $lMeta['thumb_url'];
    }
    return $pArray;
  }
}