<?php
/**
 * generates the yiid-avatar html-tags
 *
 * @author Matthias Pfefferle
 */

/**
 * Generates URL Path for a given Avatar
 *
 * @param string $pSource
 * @param string $pSize
 * @param boolean $pAbsolute
 * @return string
 */
function avatar_path($pSource, $pSize, $pAbsolute = false) {
  $lSource = ImageUtils::generateAvatarUrl($pSource, $pSize);

  return image_path($lSource, $pAbsolute);
}

/**
 * Display avatar
 *
 * @param string $pSource
 * @param string $pSize
 * @param array $pOptions
 * @return string
 */
function avatar_tag($pSource, $pSize, $pOptions = array()) {
  return image_tag(avatar_path($pSource, $pSize), $pOptions);
}