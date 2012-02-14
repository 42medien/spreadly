/*
 * @nocombine test 
 */

(function( $ ){
  var SpreadlyButton = {
    aParams: {},
      
    initCss: function() {
      var lHead = document.getElementsByTagName("head")[0];
      var lLink = document.createElement('link');
      lLink.rel = 'stylesheet';
      lLink.href = 'http://spreadly.local/css/widget/spreadlybutton.css';
      lLink.type = 'text/css';
      lLink.media = 'screen';
      lHead.appendChild(lLink);
    },
    
  
    initImages: function(pObject) {
      jQuery(pObject).prepend('<img src="//s-static.ak.facebook.com/rsrc.php/yi/r/q9U99v3_saj.ico">');
      jQuery(pObject).prepend('<img src="//twitter.com/phoenix/favicon.ico">');
      jQuery(pObject).prepend('<img src="//ssl.gstatic.com/s2/oz/images/faviconr.ico">');
      jQuery(pObject).prepend('<img src="//s3.licdn.com/scds/common/u/img/favicon_v3.ico">');
      
    },
    
    initClick: function(pObject) {
      pObject.onclick = function(){
        
        var lUrl = this.href;
        //console.log(lUrl);
        SpreadlyWindow.open(lUrl);
        return false;
      };
      /*
      jQuery(pObject).unbind().bind('click', function() {
        var lUrl = jQuery(pObject).attr('href');
        SpreadlyWindow.open(lUrl); 
        return false;
      });*/
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
      //jQuery('<div id="spreadly_overlay"><div></div></div>').appendTo('body');
      SpreadlyWindow.create();
      //SpreadlyWindow.initCss();
      SpreadlyWindow.close();
      
    },
    
    create: function(){
      var lSpreadlyWindow = document.createElement("div");
      var lWindowInner =  document.createElement("div");
      var lBody = document.getElementsByTagName("body")[0];
      lSpreadlyWindow.setAttribute('id', 'spreadly_overlay');
      lSpreadlyWindow.appendChild(lWindowInner);
      lBody.appendChild(lSpreadlyWindow);

    },
    
    open: function(pUrl) {
      SpreadlyWindow.insertIframe(pUrl);
      document.getElementById('spreadly_overlay').style.visibility = "visible";    
    },
    
    insertIframe: function(pUrl) {
      var lIframe = document.createElement('iframe');
      lIframe.setAttribute('src', 'http://spread.local/?url='+pUrl+'&iframe=1');
      lIframe.style.width = "555px";
      lIframe.style.height = "450px";
      lIframe.style.border = "0";
      document.getElementById('spreadly_overlay').firstChild.appendChild(lIframe);
      //jQuery('#spreadly_overlay div').append('<iframe src="http://spread.local/?url='+pUrl+'&iframe=1" style="width: 555px; height: 450px; border:0;"></iframe>');
      
    },
    
    close: function() {
      document.getElementById('spreadly_overlay').onclick = function(){
        var lOverlay = document.getElementById('spreadly_overlay'); 
        lOverlay.style.visibility = "hidden";
        lOverlay.firstChild.innerHTML = "";
        //jQuery('#spreadly_overlay div').empty();        
        return true;
      };      
      
      /*
      jQuery('#spreadly_overlay').click(function() {
        jQuery(this).css('visibility', 'hidden');
        jQuery('#spreadly_overlay div').empty();        
        return true;
      }); */
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
;