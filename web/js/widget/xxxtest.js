/*
 * @nocombine test 
 */

(function( $ ){
  var SpreadlyButton = {
    initCss: function(pObject) {
      var lColor;
      console.log(pObject);
      jQuery(pObject).css({
        "background": "#fff url('/img/button/test-share-button.png') no-repeat 0 0",
        "display": "inline-block",
        "width":'54px',
        "height":'18px',
        "position": "relative",
        "color": "hsl(331,42%,50%)",
        "line-height": "18px",
        "font-weight": "bold",
        "text-rendering": "optimizeLegibility",
        "-webkit-font-smoothing": "antialiased",
        "padding": "0 4px 0 21px",
        "border": "1px solid hsl(331,42%,73%)",
        "border-bottom-color": "hsl(331,42%,50%)",
        "border-top-color": "hsl(331,42%,81%)",
        "border-radius": "3px",
        "background": "#fff url('//s3.amazonaws.com/spread.ly/img/button/s.png') no-repeat 130% -20px",
        "text-decoration": "none",
        "text-transform": "uppercase",
        "box-shadow": "0 -1px 1px 1px hsla(331,42%,100%,.7) inset, 0 -4px 8px 0 hsla(331,42%,50%,.5) inset, 0 0 2px 8px hsla(331,42%,0%,0)",
        "text-shadow": "0 1px 1px #fff, 0 -1px 1px hsla(331,42%,50%,.25)",
        "-webkit-transition": "box-shadow .3s ease-out, text-shadow .3s ease-out, background-position .6s ease-out",
        "-moz-transition": "box-shadow .3s ease-out, text-shadow .3s ease-out, background-position .6s ease-out"        
      });
    },
    
    initHover: function(pObject) {
      console.log('initHover');
      jQuery(pObject).hover(function() {
        console.log(pObject);
        jQuery(pObject).css({
          "outline": "none",
          "background-position": "-30% 20px",
          "border": "1px solid hsl(331,42%,65%)",
          "border-top-color": "hsl(331,42%,46%)",
          "box-shadow": "0 0 0 1px #fff inset, 0 6px 12px 0 hsla(331,42%,.3) inset, 0 0 4px 0 hsla(331,42%,30%,.5)",
          "text-shadow": "0 1px 1px hsla(331,42%,50%,.25), 0 -1px 1px #fff",
          "-webkit-transition": "box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out",
          "-moz-transition": "box-shadow .3s ease-in, text-shadow .3s ease-in, background-position .6s ease-out"          
        });
        
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
      SpreadlyButton.initHover(this);
      SpreadlyButton.initClick(this);
    });
  };
})( jQuery );

