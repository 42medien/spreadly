jQuery.fn.inputfilter = function(pParams) {
  var lParams = pParams;
  var lAction = lParams['action'];
  var lCallback = lParams['callback'];
  var lParent = jQuery('#'+lParams['parentid']);
  var lFilter, lCount=0;
  
  return this.each(function(){
    jQuery(this).bind('keyup', function() {
      lFilter = jQuery(this).val();
      
      jQuery.ajax({
        type: 'GET',
        dataType:"json",
        url: lAction,
        data: {'sortname': lFilter},
        success: function(pResponse) {
          if(lCallback.indexOf('.') != -1) {
            //explode the string between the dot
            var lArray = lCallback.split('.');          
          
            window[lArray[0]][lArray[1]](pResponse);
          } else {
            window[lCallback](pResponse);
          }
        }
      });      
    });
  });
};