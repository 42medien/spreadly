/*
 * @combine buttonlist 
 */

//(function( $ ){


  var Spreadly = {
      
    aBoxes: [],      
      
    init: function() {
      Spreadly.initCss();
      Spreadly.initBoxes();
      Spreadly.initFB();
      Spreadly.initTwitter();
      Spreadly.initGoogle();      
      
    },
    
    initCss: function() {
      var lHead = document.getElementsByTagName("head")[0];
      var lLink = document.createElement('link');
      lLink.rel = 'stylesheet';
      lLink.href = 'http://spreadly.com/css/widget/spreadlywidget.css';
      lLink.type = 'text/css';
      lLink.media = 'screen';
      lHead.appendChild(lLink);
    },
    
    initBoxes:function() {
      Spreadly.aBoxes = document.getElementsByClassName('spreadly-box');
      for(var i = 0; i < Spreadly.aBoxes.length; i++) {
        SpreadlyBox.init(Spreadly.aBoxes[i]);
        
      }
      
    },
    
    initFB: function (){
      
      document.getElementsByTagName("body")[0].insertAdjacentHTML('beforeend', '<div id="fb-root"></div>');
      
      window.fbAsyncInit = function() {
        FB.init({
          appId      : '139206476740', // App ID
          status     : true,
          cookie     : false,
          xfbml      : true  
        });
      };

      (function(d){
         var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
         if (d.getElementById(id)) {return;}
         js = d.createElement('script'); js.id = id; js.async = true;
         js.src = "//connect.facebook.net/en_US/all.js";
         ref.parentNode.insertBefore(js, ref);
       }(document));  
      
    },
    
    initTwitter: function() {
      !function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0];if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src="//platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");
    },
    
    initGoogle: function() {
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/plusone.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    }    
    
      
  };

  var SpreadlyBox = {
      
    aUrl: null,
      
    init: function(pBox) {
      SpreadlyBox.setUrl(pBox);
      var lButtons = pBox.getElementsByTagName('a');
      for(var i = 0; i < lButtons.length; i++){
        if(SpreadlyUtils.hasClass(lButtons[i], 'spreadly-fb-button')) {
          SpreadlyFbButton.insert(lButtons[i]);
        }

        
        if(SpreadlyUtils.hasClass(lButtons[i], 'spreadly-google-button')) {
          SpreadlyGoogleButton.insert(lButtons[i]);          
        }        
        
        if(SpreadlyUtils.hasClass(lButtons[i], 'spreadly-twitter-button')) {
          SpreadlyTwButton.insert(lButtons[i]);          
        }  
        
        if(SpreadlyUtils.hasClass(lButtons[i], 'spreadly-button')) {
          SpreadlyButton.insert(lButtons[i]);          
        }         
      }
    },
    
    setUrl: function(pBox) {
      SpreadlyBox.aUrl = pBox.getAttribute('data-href');
      SpreadlyBox.aUrl = SpreadlyBox.aUrl.replace(/\s/g, "");      
      if(SpreadlyBox.aUrl == null) {
        SpreadlyBox.aUrl = location.href;
      } else if(SpreadlyBox.aUrl == '') {
        SpreadlyBox.aUrl = location.href;
      }
    }
      
  };
  
  var SpreadlyFbButton = {
    
    getButton: function() {
      return '<div class="fb-like" data-href="'+SpreadlyBox.aUrl+'" data-send="false" data-layout="button_count" data-width="80" data-show-faces="false" data-font="arial"></div>';
    },
    
    insert: function(pButton) {
        pButton.insertAdjacentHTML('afterbegin', SpreadlyFbButton.getButton());
    }
      
  };
  
  var SpreadlyTwButton = {
  
    getButton: function() {
      return '<a href="https://twitter.com/share" data-url="'+SpreadlyBox.aUrl+'" class="twitter-share-button" data-via="spreadly">Tweet</a>';
    },    
    
    insert: function(pButton) {
      pButton.insertAdjacentHTML('afterbegin', SpreadlyTwButton.getButton());
      
    }    
    
  };
  
  var SpreadlyGoogleButton = {
      
      getButton: function() {
        return '<div class="g-plusone" data-size="medium" data-href="'+SpreadlyBox.aUrl+'"></div>';
      },       
      
      insert: function(pButton) {
        pButton.insertAdjacentHTML('afterbegin', SpreadlyGoogleButton.getButton());
      }       
      
  };


  var SpreadlyButton = {
    
    getButton: function() {
      return '<iframe src="http://button.spread.ly/?url='+SpreadlyBox.aUrl+'&color=000000&label=Like&social=0" style="overflow:hidden; width: 170px; height: 23px; padding: 0px 0;" frameborder="0" scrolling="no" marginheight="0" allowTransparency="true"></iframe>';
    },           
    
    insert: function(pButton) {
      pButton.insertAdjacentHTML('afterbegin', SpreadlyButton.getButton());
    }
  };
  
  var SpreadlyUtils = {
      
    hasClass: function (el, cssClass) {
        return el.className && new RegExp("(^|\\s)" + cssClass + "(\\s|$)").test(el.className);
    }
  };