/*
 * @nocombine test 
 */

(function( $ ){
  var SpreadlyButton = {
    aParams: {},
      
    initCss: function() {
      jQuery('head').append('<link rel="stylesheet" href="http://spreadly.local/css/widget/spreadlybutton.css" type="text/css" />');
    },
    
  
    initImages: function(pObject) {
      jQuery(pObject).prepend('<img src="//s-static.ak.facebook.com/rsrc.php/yi/r/q9U99v3_saj.ico">');
      jQuery(pObject).prepend('<img src="//twitter.com/phoenix/favicon.ico">');
      jQuery(pObject).prepend('<img src="//ssl.gstatic.com/s2/oz/images/faviconr.ico">');
      jQuery(pObject).prepend('<img src="//s3.licdn.com/scds/common/u/img/favicon_v3.ico">');
      
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
      jQuery('<div id="spreadly_overlay"><div></div></div>').appendTo('body');
      //SpreadlyWindow.initCss();
      SpreadlyWindow.close();
      
    },
    
    open: function(pUrl) {
      SpreadlyWindow.insertIframe(pUrl);
      jQuery('#spreadly_overlay').css('visibility', 'visible');
    },
    
    insertIframe: function(pUrl) {
      jQuery('#spreadly_overlay div').append('<iframe src="http://spread.local/?url='+pUrl+'&iframe=1" style="width: 555px; height: 450px; border:0;"></iframe>');
      
    },
    
    close: function() {
      jQuery('#spreadly_overlay').click(function() {
        jQuery(this).css('visibility', 'hidden');
        jQuery('#spreadly_overlay div').empty();        
        return true;
      }); 
    }
  };
  
  
  jQuery.fn.spreadly = function( pParams ){
    SpreadlyButton.aParams = pParams;
    SpreadlyWindow.init();
    SpreadlyButton.initCss();
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
