<?php
/**
 * a parser for metatags
 *
 * @author Karina Mies
 */
class MetaTagParser {

  /**
   * Enter description here...
   *
   * @param string $pUrl
   */
  public static function parse($pHtml) {
  	try {
	    $lValues = array();
	    libxml_use_internal_errors(true);
	    $lDoc = new DOMDocument();
	    $lDoc->loadHTML($pHtml);

	    $lTags = $lDoc->getElementsByTagName('meta');
	    foreach ($lTags as $lTag) {
	      if ($lTag->hasAttribute('name')) {
	        $lName = $lTag->getAttribute('name');
	        $lValues[$lName] = $lTag->getAttribute('content');
	      }
	    }

	    $lTitles = $lDoc->getElementsByTagName('title');
	    foreach ($lTitles as $lMetaTitle) {
	      $lTitle = $lMetaTitle->nodeValue;
	      if($lTitle){
	      	$lValues['title'] = $lTitle;
	        continue;
	      }
	    }
	    return $lValues;
  	}catch (Exception $e) {
      continue;
  	}
  }

  public static function getKeys($pHtml) {
    return self::parse($pHtml);
  }
}