var WidgetLikeHandler = {
    
    init: function() {
      WidgetLikeHandler.doSend();
    },
    
    
    initSlider: function(){
      jQuery("#myscroll").scrollable({
        circular: false
      });

      jQuery('#slide-next-link').bind('click', function() {
        var lChildren = jQuery('.scrollables .items > div').size();
      });
    },
    
    
    doSend: function() {
      
    },
    
    getImages: function(pUrl) {
      var lAction = '/like/get_images';
      var lData = {
        ei_kcuf : new Date().getTime(),
        url: pUrl
      };
      
      jQuery.ajax({
        //beforeSubmit : OnLoadGrafic.showGrafic,
        type : "GET",
        url : lAction,
        dataType : "json",
        data : lData,
        success : function(pResponse) {
          jQuery('#scroll-meta-images').empty();
          jQuery('#scroll-meta-images').append(pResponse.html);
          WidgetLikeHandler.initSlider();
        }
      });        
    }
    
};