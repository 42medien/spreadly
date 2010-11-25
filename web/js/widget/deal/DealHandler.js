/**
 * @nocombine likepopup
 */

var DealNav = {
  init: function() {
    debug.log('[DealNav][init]');
    DealNav.toggle();
    
  },
  
  toggle: function() {
    debug.log('[DealNav][toggle]');
    jQuery('.deal-nav-elem').live('click', function() {
      var lAction = jQuery(this).attr('href');
      
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        data: { ei_kcuf: new Date().getTime() },        
        success: function (pResponse) {
          jQuery('#deal_content_main').empty();
          jQuery('#deal_content_main').append(pResponse.html);
        }
      });
      return false;
    });
  }
    
    
};