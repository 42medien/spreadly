jQuery.fn.inputfilter = function(pParams) {
  var lParams = pParams;
  var lUrl = lParams['url'];
  var lCallback = lParams['callback'];
  var lParent = jQuery('#'+lParams['parentid']);
  var lMinchar = lParams['minchar'];
  var lFilter;
  
  return this.each(function(){
    jQuery(this).keyup(function() {
      lFilter = jQuery(this).val();
      if(!lParams['minchar'] || lFilter.length > lParams['minchar']) {
        jQuery.ajax({
          type: "GET",
          url: lUrl,
          dataType: "json",
          data: {'sortname':lFilter},
          success: function(pResponse) {
            jQuery(lParent).empty();
            jQuery(lParent).append(pResponse.html);
            if(lCallback!== undefined) {
              lCallback(pResponse);
            }
          }
        });
      }
    });
  });
};

