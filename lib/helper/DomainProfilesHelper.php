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
  $src = "/img/";
  switch($domain_profile->getState()) {
    case DomainProfileTable::STATE_PENDING:
    	$src = $src."unverified-icon.gif";
      //$src = $src.(intval($domain_profile->getVerificationCount())<=0 ? "warning" : "warning").".png";
      break;
    case DomainProfileTable::STATE_VERIFIED:
      $src = $src."verified-success-icon.gif";
      break;
  }
  return $src;
}
