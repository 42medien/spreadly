/*
 * @nocombine test 
 */

(function( $ ){
  var SpreadlyButton = {
    aParams: {},
      
    initImages: function(pObject) {
      jQuery(pObject).text("");
      jQuery(pObject).prepend('<img src="//spread.local/img/button/28/sl.png" alt="" class="spreadly-service-icon" />');
      jQuery(pObject).prepend('<img src="//spread.local/img/button/28/li.png" alt="" class="spreadly-service-icon" />');
      jQuery(pObject).prepend('<img src="//spread.local/img/button/28/tw.png" alt="" class="spreadly-service-icon" />');
      jQuery(pObject).prepend('<img src="//spread.local/img/button/28/fb.png" alt="" class="spreadly-service-icon" />');
    },
    
    initClick: function(pObject) {
      jQuery(pObject).unbind().bind('click', function() {
        var lUrl = jQuery(pObject).attr('href');
        SpreadlyWindow.open(lUrl); 
        return false;
      });
    },

    initText: function(pObject){
      var lText = jQuery(pObject).text();
      jQuery(pObject).text("");
      if(lText == ""){
        lText = SpreadlyButton.aParams.spreadtext;
        if(lText == "" || lText == undefined){
          lText = "like";
        }
      }
      jQuery(pObject).append(lText);
    }
  };

  var SpreadlyWindow = {
    init: function() {
      jQuery('<div id="spreadly-overlay"><div id="spreadly-iframe"></div></div>').appendTo('body');
      SpreadlyWindow.close();  
    },

    open: function(pUrl) {
      SpreadlyWindow.insertIframe(pUrl);
      jQuery('#spreadly-overlay').css('visibility', 'visible');
    },
    
    insertIframe: function(pUrl) {
      jQuery('#spreadly-overlay #spreadly-iframe').append('<div class="spreadly-close-button"><div class="spreadly-close-icon" onclick="closeLayer()"></div></div><iframe src="//spread.local/?url='+pUrl+'&iframe=1" style="width: 600px; height: 450px; border:0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>');
    },

    close: function() {
      jQuery('#spreadly-overlay').click(function() {
        jQuery(this).css('visibility', 'hidden');
        jQuery('#spreadly-overlay #spreadly-iframe').empty();        
        return true;
      }); 
    }
  };

  jQuery.fn.spreadly = function( pParams ){
    SpreadlyButton.aParams = pParams;
    SpreadlyWindow.init();
    return this.each(function(){
      SpreadlyButton.initClick(this);
      SpreadlyButton.initText(this);
      SpreadlyButton.initImages(this);      
    });
  };
})( jQuery );

jQuery(document).ready( function() {
  jQuery('.spreadly-button').spreadly({});
});