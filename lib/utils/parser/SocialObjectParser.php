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
  public static function fetch($pUrl, $pYiidActivity = null) {
    $pUrl = urldecode($pUrl);

    try {
      //get the html as string
      $lHtml = UrlUtils::getUrlContent($pUrl, 'GET');

      // boost performance and use alreade the header
      $lHeader = substr( $lHtml, 0, stripos( $lHtml, '</head>' ) );

      if (!$pYiidActivity) {
        $pYiidActivity = new YiidMeta();
      }

      if (preg_match('~http://opengraphprotocol.org/schema/~i', $lHeader)  && !$pYiidActivity->isComplete()) {
        //get the opengraph-tags
        $lOpenGraph = OpenGraph::parse($lHeader);
        $pYiidActivity->fromOpenGraph($lOpenGraph);
      }

      if ((preg_match('~application/(xml|json)\+oembed"~i', $lHeader)) && !$pYiidActivity->isComplete()) {
        $lOEmbed = OEmbedParser::fetchByCode($lHeader);
        $pYiidActivity->fromOembed($lOEmbed);
      }

      if (!$pYiidActivity->isComplete()) {
        $lMeta = MetaTagParser::getKeys($lHtml, $pUrl);
        $pYiidActivity->fromMeta($lMeta);
        /*
        if (!$lYiidMeta->getImages()) {
          foreach (ImageParser::fetch($lHtml, $pUrl) as $images) {
            $imgs[] = $images['image'];
          }

          $lYiidMeta->setImages($imgs);
        }
        */
      }

      return $lYiidMeta;
    } catch (Exception $e) {}
  }
}