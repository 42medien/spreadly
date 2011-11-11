/*
 * @nocombine test 
 */

(function( $ ){
  var SpreadlyButton = {
    initCss: function(pObject) {
      jQuery(pObject).css({
        "background": "#fff url('/img/button/test-share-button.png') no-repeat 0 0",
        "display": "inline-block",
        "width":'54px',
        "height":'17px'
      });      
    },
    
    initClick: function(pObject) {
      jQuery(pObject).unbind().bind('click', function() {
        var lUrl = jQuery(pObject).attr('href');
        SpreadlyWindow.open(lUrl); 
        return false;
      });
    }
  };
  

  var SpreadlyWindow = {
    init: function() {
      jQuery('<div id="spreadly_overlay"><div></div></div>').appendTo('body');
      SpreadlyWindow.initCss();
      SpreadlyWindow.close();
      
    },
    
    initCss: function() {
      jQuery('#spreadly_overlay').css({
        "visibility": "hidden",
        "position": "absolute",
        "left":'0px',
        "top":'0px',
        "width": "100%",
        "height": "100%",
        "text-align":'center',
        "z-index":'99999',
        "background-color": '#fff',
        "opacity": '0.9'
      });
      
      jQuery('#spreadly_overlay div').css({
        "width": "540px",
        "margin": "10% auto",
        "background-color":'#fff',
        "text-align":'center'
      });      
    },
    
    open: function(pUrl) {
      SpreadlyWindow.insertIframe(pUrl);
      jQuery('#spreadly_overlay').css('visibility', 'visible');
    },
    
    insertIframe: function(pUrl) {
      jQuery('#spreadly_overlay div').append('<iframe src="http://spread.local/?url='+pUrl+'&iframe=1" style="width: 555px; height: 400px; border:0;"></iframe>');
      
    },
    
    close: function() {
      jQuery('#spreadly_overlay').click(function() {
        jQuery(this).css('visibility', 'hidden');
        jQuery('#spreadly_overlay div').empty();        
        return true;
      }); 
    }
  };
  
  
  jQuery.fn.spreadly = function( method ){
    SpreadlyWindow.init();
    return this.each(function(){
      SpreadlyButton.initCss(this);
      SpreadlyButton.initClick(this);
    });
  };
})( jQuery );

