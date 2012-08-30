<?php
/**
 * handles the i18n functionality for the like/dislike button
 *
 * @author Matthias Pfefferle
 */
$lSupportetLanguages = array('de', 'en', 'tr');

if ((isset($_GET['cult']) && !empty($_GET['cult'])) && in_array($lLang, $lSupportetLanguages)) {
  $lLang = $_GET['cult'];
} else {
  // set default language
  $lLang = "de";
}

require_once("lang/".$lLang.".php");

/**
 * returns the translation for the selected language
 *
 * @author Matthias Pfefferle
 * @param string $pWildcard
 * @param string $pType
 * @return string
 */
function __($pWildcard, $pType = "global") {
  global $i18n;

  return $i18n[$pType][$pWildcard];
}
?>