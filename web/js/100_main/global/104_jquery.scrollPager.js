/**
 * @combine platform
 * @combine statistics
 */
jQuery.fn.scrollPager = function(pParams){
  var lAction = pParams['url'];
  var lPage = 2;
  var lElement = this;
  var lCallback = pParams['callback'];
  jQuery(this).bind('scroll', function() {
    var scrolltop = jQuery(lElement).attr('scrollTop');
    var scrollheight = jQuery(lElement).attr('scrollHeight');
    var windowheight = jQuery(lElement).attr('clientHeight');
    var scrolloffset = 0;
    if (scrolltop >= (scrollheight-(windowheight+scrolloffset)) && lPage != undefined) {
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