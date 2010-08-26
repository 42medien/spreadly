/**
 * @nocombine platform
 */
jQuery.fn.scrollPager = function(pParams){
  var lAction = pParams['url'];
  var lPage = 1;
  var lElement = this;
  var lCallback = pParams['callback'];  
  debug.log(this);
  jQuery(this).bind('scroll', function() {
    var scrolltop = jQuery(lElement).attr('scrollTop');  
    var scrollheight = jQuery(lElement).attr('scrollHeight');  
    var windowheight = jQuery(lElement).attr('clientHeight');
    var scrolloffset = 0;
    if (scrolltop >= (scrollheight-(windowheight+scrolloffset)) && lPage != undefined) {
      debug.log("page: "+lPage);
      debug.log("height: "+(scrollheight-(windowheight+scrolloffset)));
      debug.log("scrolltop: "+scrolltop);
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        data: {'page': lPage},
        success: function(pResponse) {
          if(lCallback!== undefined) {
            lCallback(pResponse);
          }          
          jQuery(lElement).append(pResponse.html);
          if(pResponse.pDoPaginate === false) {
            lPage = undefined;
          } else {
            lPage++;
          }
        }
      });        
    }      
  });
};