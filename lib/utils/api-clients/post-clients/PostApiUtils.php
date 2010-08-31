<?php
/**
 * Utils for Postapi Clients
 *
 * @author Christian Weyand
 */
class PostApiUtils {

  /**
   *
   * generate Wildcard.. truncate if necessary, $pUrl is optional
   *
   * @param string $pType
   * @param int $pScore
   * @param string $pTitle
   * @param string $pUrl
   * @param int $pMaxLength
   * @return string
   */
  public static function generateMessage($pType, $pScore, $pTitle = null, $pUrl = null, $pMaxLength = null) {
    sfProjectConfiguration::getActive()->loadHelpers('Text');
    if ($pTitle) {
      $pTitle = '"'.$pTitle.'"';
    }

    $i18n = sfContext::getInstance()->getI18N();
    $lWildcard = 'POSTAPI_MESSAGE_'.strtoupper($pType) . ($pScore<0?'_NOT':'');
    if ($pMaxLength) {
      $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');
      $lText = truncate_text($lText, $pMaxLength , '...');
    } else {
      $lText = $i18n->__($lWildcard, array('%title%' => $pTitle, '%url%' => $pUrl), 'widget');
    }
    return $lText;
  }

}