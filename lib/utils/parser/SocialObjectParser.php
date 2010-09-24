<?php
// required because its called like a batch outside of the symfony context
require_once(dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php');

$configuration = ProjectConfiguration::getApplicationConfiguration('platform', 'batch', true);
sfContext::createInstance($configuration);

/**
 * a parser for social objects
 *
 * @author Matthias Pfefferle
 */
class SocialObjectParser {

  /**
   * handles the parsing of a new social-object
   * currently parsed: opengraph and metatags
   *
   * @param string $pUrl
   * @return array $pArray
   */
  public static function fetch($pUrl) {
    try {
      //get the html as string
      $lHtml = UrlUtils::getUrlContent($pUrl, 'GET');
      //get the opengraph-tags
      $lOpenGraph = OpenGraph::parse($lHtml);
      $lToSave = array();

      //if there are some og-metas: save it to an array
      if($lOpenGraph) {
        $lToSave['title'] = $lOpenGraph->__get('title');
        $lToSave['thumb_url'] = $lOpenGraph->__get('image');
        $lToSave['stmt'] = $lOpenGraph->__get('description');
      } else {
        //if there are no og-metas, check if there are some html-metas and get it
        $lKeys = MetaTagParser::getKeys($lHtml);
        $lToSave['title'] = (isset($lKeys['title']))?$lKeys['title']:null;
        $lToSave['stmt'] = (isset($lKeys['description']))?$lKeys['description']:null;
        $lToSave['thumb_url'] = null;
      }
      return $lToSave;
    }catch (Exception $e) {

    }
  }

  /**
   * saves the found meta-tags to the array to save
   * @param array $pArray
   * @return array $pArray
   */
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


  public static function enrich($pMessage) {
    $pUrl = urldecode($pMessage[0]['Body']);
    sfContext::getInstance()->getLogger()->info("{SocialObjectParser} checking url: " . $pUrl );
    $lSocialObject = SocialObjectTable::retrieveByUrl($pUrl);

    if (!$lSocialObject) {
     $lSocialObject = SocialObjectTable::initializeObjectFromUrl($pUrl, SocialObjectTable::ENRICHED_TYPE_OBJECTPARSER);
    }


    sfContext::getInstance()->getLogger()->info("{SocialObjectParser} social object: " . print_r($lSocialObject, true) );
  }
}