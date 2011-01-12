/**
 * @combine platform
 */

/**
 * jQuery-Plugin to make a request and append the response-data on a specified box/list/etc
 * the specified action has to response an json with an html attribute
 * the specified action gets an sortname-params
 * e.g: moduel/action?sortname=ha
 * 
 * @param object pParams
 * @param string pParams[url]: required url to action
 * @param string pParams[callback]: optional callback function that gets the whole response
 * @param string pParams[parentid]: required cssid for the element where the response has to inserted
 * @param string pParams[minchar]: optional number of minimum filter-characters
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