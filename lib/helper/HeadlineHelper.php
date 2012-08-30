<?php
/**
 * a helper for fast and easy view of headlines styled with css and sprites
 *
 * @author Christian Schätzle
 */

/**
 * helper to display green headline
 *
 * @param string $name the text to be displayed
 * @param int $pWidthExt the width of the extension element
 * @param int $pMarginTop margin-top
 * @return string a html formatted area
 */
function green_headline($pName, $pMarginTop = 20, $pWidthExt = 80) {
	
	$lHeadline = '
    <div class="green_head clearfix" style="margin-top: '.$pMarginTop.'px;">
      <div class="green_head_part1"></div>
      <div class="green_head_part2 important_text color_light" style="width:'.$pWidthExt.'%;">'.$pName.'</div>
      <div class="green_head_part3" style="left:'.$pWidthExt.'%"></div>
      <div class="green_head_part4"></div>
    </div>
	';
  
  return $lHeadline;
}

/**
 * helper to display grey headline
 *
 * @param string $name the text to be displayed
 * @param int $pMarginTop margin-top
 * @param int $pWidthExt the width of the extension element
 * @return string a html formatted area
 */
function grey_headline($pName, $pMarginTop = 20, $pWidthExt = 80) {
  
  $lHeadline = '
    <div class="grey_head clearfix" style="margin-top: '.$pMarginTop.'px;">
		  <div class="grey_head_part1"></div>
		  <div class="grey_head_part2 important_text color_light" style="width:'.$pWidthExt.'%;">'.$pName.'</div>
		  <div class="grey_head_part3" style="left:'.$pWidthExt.'%"></div>
		  <div class="grey_head_part4"></div>
		</div>
  ';
  
  return $lHeadline;
}

?>