/**
 * @combine widget
 */

var NoUrlForm = {
    init: function (){
      jQuery('#man-url-input').toggleValue();
      NoUrlForm.bindKeyNav();
    },
    
    /**
     * updates widgets after typing a url
     * @author KM
     */   
    bindKeyNav: function() {
      debug.log("[NoUrlForm][bindKeyNav]");       
      var lTimeout;
      jQuery('#man-url-input').keyup(function(e) {
        clearTimeout(lTimeout);
        lTimeout = setTimeout(function() {
          WidgetLikeContent.get();
        }, 300);
      });    
    }
};