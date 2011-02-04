<?php
// required because its called like a batch outside of the symfony context
require_once(dirname(__FILE__).'/../../../config/ProjectConfiguration.class.php');
require_once(dirname(__FILE__).'/../../vendor/OpenGraph/OpenGraph.php');

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

      // boost performance and use alreade the header
      $lHeader = substr( $lHtml, 0, stripos( $lHtml, '</head>' ) );

      $lYiidMeta = new YiidMeta();

      if (preg_match('~http://opengraphprotocol.org/schema/~i', $lHeader)) {
        //get the opengraph-tags
        $lOpenGraph = OpenGraph::parse($lHeader);
        $lYiidMeta->fromOpenGraph($lOpenGraph);
      }

      if ((preg_match('~application/(xml|json)\+oembed"~i', $lHeader)) && !$lYiidMeta->isComplete()) {
        $lOEmbed = OEmbedParser::fetchByCode($lHeader);
        $lYiidMeta->fromOembed($lOEmbed);
      }

      if (!$lYiidMeta->isComplete()) {
        $lMeta = MetaTagParser::getKeys($lHtml, $pUrl);
        $lYiidMeta->fromMeta($lMeta);

        if (!$lYiidMeta->getImages()) {
          foreach (ImageParser::fetch($lHtml, $pUrl) as $images) {
            $imgs[] = $images['image'];
          }
          $lYiidMeta->setImages($imgs);
        }
      }

      return $lYiidMeta;
    } catch (Exception $e) {

    }
  }

  public static function enrich($pMessage) {
    $lUpdateArray = array();
    $pUrl = urldecode($pMessage[0]['Body']);

    if (!UrlUtils::checkUrlAvailability($pUrl)) {
      sfContext::getInstance()->getLogger()->info("{SocialObjectParser} invalid url: " . $pUrl );
      return false;
    }
    sfContext::getInstance()->getLogger()->info("{SocialObjectParser} checking url: " . $pUrl );
    $lSocialObject = SocialObjectTable::retrieveByAliasUrl($pUrl);

    if (!$lSocialObject) {
      SocialObjectTable::initializeObjectFromUrl($pUrl, SocialObjectTable::ENRICHED_TYPE_OBJECTPARSER);
      $lSocialObject = SocialObjectTable::retrieveByAliasUrl($pUrl);
    }

    $lParsedInformation = self::fetch($pUrl);

    $lTitle = StringUtils::cleanupString($lParsedInformation['title'], false);
    if ($lTitle != "" ) {
      $lUpdateArray['title'] = $lTitle;
    }
    $lStmt = StringUtils::cleanupString($lParsedInformation['stmt'], false);
    if ($lStmt != "") {
      $lUpdateArray['stmt'] = $lStmt;
    }

    if (!empty($lUpdateArray)) {
      try {
        SocialObjectTable::updateObjectInMongoDb(array("url_hash" => md5($pUrl)), array('$set' => $lUpdateArray ));
      }
      catch (Exception $e) {
        sfContext::getInstance()->getLogger()->err("{SocialObjectParser} PROBLEM on update: " . print_r($lUpdateArray, true) );
      }
    }
  }
}