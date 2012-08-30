/**
 * @nocombine platform
 */

/**
 * jQuery-Plugin to toggle checkboxes
 * jQuery('#advanced-options-link').toggleboxes({
 *  "id":"advanced-options-box"
 * });
 * 
 */
jQuery.fn.toggleboxes = function(pParams) {
  var lParams, lId, lCallback;
  lParams = pParams;
  lId = pParams['id'];
  lCallback = pParams['callback'];
  
  jQuery(this).bind('click', function() {
    jQuery('#'+lId).toggle(); 
    if (typeof lCallback == 'function') { // make sure the callback is a function
      lCallback.call(this); // brings the scope to the callback
    }
    return false;
  });
};