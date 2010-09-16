/**
 * @combine platform
 */

/**
 * jQuery-Plugin to fadein/out an message list
 *
 * @param object pParams
 * @param string pParams[msg]: jsonstring with messages
 * @param string pParams[speed]: optional for speed of fadein/out
 * @param string pParams[timeout]: optional for time to fadeout
 *
 */
jQuery.fn.topslider = function(pParams) {
  var lParams = pParams, lSpeed, lTimeout, lThis, lMsgs;
  lSpeed = (lParams.speed)?lParams.speed:1500;
  lTimeout = (lParams.timeout)?lParams.timeout:2000;
  lThis = this;
  lMsgs = jQuery.parseJSON(lParams["msg"]);
  jQuery(lThis).empty();
  var lList = "<ul class='error-msg-list'>";
  for(var i=0; i<lMsgs.length; i++) {
    lList += "<li>";
    lList += lMsgs[i];
    lList += "</li>";
  }
  lList += "</ul>";

  jQuery(lThis).append(lList);
  jQuery(lThis).show('blind', null, lSpeed);
  window.setTimeout(function() {
    jQuery(lThis).hide('blind', null, lSpeed);
    jQuery(lThis).empty();
  },lTimeout);
};

