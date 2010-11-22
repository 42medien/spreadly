<?php
/**
 * the domain profiles helper
 *
 * @author hannes
 */

/**
 * helper get a corresponding image for a certain state
 *
 * @param string $state the state
 * @return an image src
 */
function get_state_image_src($domain_profile) {
  $src = "/img/global/";
  switch($domain_profile->getState()) {
    case DomainProfileTable::STATE_PENDING:
    	$src = $src."warning.png";
      //$src = $src.(intval($domain_profile->getVerificationCount())<=0 ? "warning" : "warning").".png";
      break;
    case DomainProfileTable::STATE_VERIFIED:
      $src = $src."accept.png";
      break;
  }
  return $src;
}
