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
  public static function fetch($pUrl, $pYiidMeta = null) {
    $pUrl = trim(urldecode($pUrl));
    $pUrl = str_replace(" ", "+", $pUrl);

    try {
      //get the html as string
      $lHtml = UrlUtils::getUrlContent($pUrl, 'GET');

      if (!$lHtml) {
        return false;
      }

      // boost performance and use alreade the header
      $lHeader = substr( $lHtml, 0, stripos( $lHtml, '</head>' ) );

      if (!$pYiidMeta) {
        $pYiidMeta = new YiidMeta();
      }

      $pYiidMeta->setUrl($pUrl);

      if ((preg_match('~http://opengraphprotocol.org/schema/~i', $lHeader) || preg_match('~http://ogp.me/ns#~i', $lHeader) || preg_match('~property=\"|\'og:~i', $lHeader)) && !$pYiidMeta->isComplete()) {
        //get the opengraph-tags
        $lOpenGraph = OpenGraph::parse($lHeader);
        $pYiidMeta->fromOpenGraph($lOpenGraph);
      }

      if ((preg_match('~application/(xml|json)\+oembed"~i', $lHeader)) && !$pYiidMeta->isComplete()) {
        try {
          $lOEmbed = OEmbedParser::fetchByCode($lHeader);
          $pYiidMeta->fromOembed($lOEmbed);
        } catch (Exception $e) {
          // catch exception and try to go on
        }
      }

      if (!$pYiidMeta->isComplete()) {
        $lMeta = MetaTagParser::getKeys($lHtml, $pUrl);
        $pYiidMeta->fromMeta($lMeta);
      }

      return $pYiidMeta;
    } catch (Exception $e) {
      return false;
    }
  }
}