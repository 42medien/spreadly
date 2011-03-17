/**
 * @nocombine platform
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
jQuery.fn.inputfilter = function(pParams) {
  var lParams = pParams;
  var lUrl = lParams['url'];
  var lCallback = lParams['callback'];
  var lMinchar = lParams['minchar'];
  var lParent = jQuery('#'+lParams['parentid']);  
  var lFilter, lTimeout;
  var lDelay = (lParams['delay'] == undefined)?0:lParams['delay'];
  
  return this.each(function(){
      jQuery(this).keyup(function(e) {
        var lKey = e.charCode || e.keyCode || 0;
        
        if(lKey != 37 && lKey != 38 && lKey != 39 && lKey != 40 && lKey != 0 && lKey != 13) {
          OnLoadGrafic.showGraficByElement(this, 50, 50);
          clearTimeout(lTimeout);
          lFilter = jQuery(this).val();
          lTimeout = setTimeout(function() {
            if(!lParams['minchar'] || lFilter.length > lParams['minchar']) {
              jQuery.ajax({
                type: "GET",
                url: lUrl,
                dataType: "json",
                data: {'sortname':lFilter, 'ei_kcuf': new Date().getTime()},
                success: function(pResponse) {
                  if(lCallback!== undefined) {
                    lCallback(pResponse);
                  }
                  jQuery(lParent).empty();
                  jQuery(lParent).append(pResponse.html);
                }
              });
            }
          }, lDelay);
        }
      });
  });
};

