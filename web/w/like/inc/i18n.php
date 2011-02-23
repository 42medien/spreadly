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

/**
 * prints an i18n javascript object
 *
 * @author Matthias Pfefferle
 * @param string $pType
 * @return string
 */
function printI18nJSObject($pType) {
  global $i18n;

  $lJS = 'var i18n = {'."\n";

  // the general translations
  foreach ($i18n['global'] as $key => $value ) {
    $lJS .= '  "'.$key.'":"'.$value.'",'."\n";
  }

  $i = 1;
  // the type-specific translations
  foreach ($i18n[$pType] as $key => $value ) {
    $lJS .= '  "'.$key.'":"'.$value.'"';

    if ($i < count($i18n[$pType])) {
      $lJS .= ',';
    }
    $lJS .= "\n";
    $i++;
  }

  $lJS .= '};';

  return $lJS;
}
?>