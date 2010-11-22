var Navigation = {
  init: function(pBoxId) {
    debug.log('[Navigation][init]');
    Navigation.toggle(pBoxId);
  },
  
  toggle: function(pBoxId) {
    jQuery('.nav-tab').live('click', function() {
      debug.log('[Navigation][toggle]');
      lAction = jQuery(this).attr('href');
      debug.log(lAction);
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        data: { ei_kcuf: new Date().getTime() },        
        success: function (pResponse) {
          jQuery('#'+pBoxId).empty();
          jQuery('#'+pBoxId).append(pResponse.html);
        }
      });
      return false;
    });
  }
};