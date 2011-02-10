var WidgetLikeHandler = {
    
    init: function() {
      WidgetLikeHandler.doSend();
    },
    
    
    initSlider: function(){
      jQuery("#myscroll").scrollable({
        circular: true
      });

      jQuery('#slide-next-link').bind('click', function() {
        var lChildren = jQuery('.scrollables .items > img').size();
        debug.log(lChildren);
      });
    },
    
    
    doSend: function() {
      
    },
    
    getImages: function() {
      
    }
    
};