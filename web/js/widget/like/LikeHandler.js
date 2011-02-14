/**
 * @nocombine widgets
 */

/**
 * Handles the sending of the like
 * @author KM
 */
var WidgetLikeForm = {
    
    /**
     * inits the form-functions
     */
    init: function() {
      debug.log('[WidgetLikeForm][init]');
      WidgetLikeForm.doSend();
    },
    
    /**
     * sends the like to the backend
     * @author KM
     */
    doSend: function() {
      debug.log('[WidgetLikeForm][doSend]');      
      
      jQuery('#popup-send-like-button').bind('click', function() {
        var lAction = jQuery('#popup-like-form').attr('action');         
        OnLoadGrafic.showGrafic();
        WidgetLikeForm.hideButton();
        WidgetLikeForm.hideTextarea();
        var options = {
          //beforeSubmit : OnLoadGrafic.showGrafic,
          url : lAction,
          data : {
            ei_kcuf : new Date().getTime()
          },
          type : 'POST',
          dataType : 'json',
          success : function(pResponse) {
            if(pResponse.success == true) {
              WidgetLikeForm.removeButton(); 
              WidgetLikeForm.removeTextarea();                 
            } else {
              WidgetLikeForm.showButton(); 
              WidgetLikeForm.showTextarea();      
            }
            
            OnLoadGrafic.hideGrafic();
          }
        };
        
         jQuery('#popup-like-form').ajaxSubmit(options);
         return false;
      });      
    },
    
    /**
     * sets the hidden img-value
     * @author KM
     * @param string pPath
     */
    setImageValue: function(pPath){
      jQuery('#like-img-value').val(pPath);
    },
    
    hideButton: function() {
      jQuery('#popup-send-like-button').hide();
    },
    
    removeButton: function() {
      jQuery('#popup-send-like-button').remove();      
    },
    
    showButton: function(){
      jQuery('#popup-send-like-button').show();      
    },
    
    hideTextarea: function() {
      jQuery('#area-like-comment').hide();
    },
    
    removeTextarea: function() {
      jQuery('#area-like-comment').remove();      
    },
    
    showTextarea: function() {
      jQuery('#area-like-comment').show();            
    }
};


/**
 * Handles the behaviour/settings of the preview image for like-messages in services
 * @author KM
 */
var LikeImage = {
    
    init: function() {
      //LikeImage.get();
    },
      
    /**
     * if there is no image given by the meta-tag-parser, try to get some from the html-content from the given url
     * @author KM 
     * @param string pUrl
     */
    get: function(pUrl) {
      OnLoadGrafic.showGraficByElement(jQuery('#myscroll'), 20, 500);
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
          LikeImage.handleResponse(pResponse);
        }
      });        
    },
    
    /**
     * handles the response after the get-images
     * @author KM
     * @param object pResponse
     */
    handleResponse: function(pResponse) {
      //insert the image into slider-container
      LikeImage.insert(pResponse.html);
      //fill the hidden-img-value with the path of the first image
      WidgetLikeForm.setImageValue(LikeImage.getImgPath(0));
      //if there is no or 1 image, hide the slide-arrows and the counter
      if(pResponse.count === 0 || pResponse.count === 1){
        LikeImageCounter.hide();
      } else {
        // if there are more than 1 images: 
        // init the scroller
        LikeImageScroller.init(true);
        //init the counter
        LikeImageCounter.init(pResponse.count);
        //show the slide-arrows and the counter
        LikeImageCounter.show();
        //and init the onscroll-functionalities (e.g. update counter & update hidden-img-value onscroll)
        LikeImageScroller.onScroll();          
      }
      OnLoadGrafic.hideGrafic();
    },
    
    /**
     * inserts the images into the scroll-area
     * @author KM
     * @param pHtml
     */
    insert: function(pHtml) {
      jQuery('#scroll-meta-images').empty();
      jQuery('#scroll-meta-images').append(pHtml);
    },
    

    /**
     * returns the image-path of a given index(position of the image into the slider)
     * @author KM
     * @param number pIndex
     * @returns string
     */
    getImgPath: function(pIndex) {
      return jQuery('#meta-img-'+pIndex).attr('src');
    } 
};


/**
 * Handles the scroll/slide functionalities
 * @author KM
 */
var LikeImageScroller = {
  aApiObj: {},
  
  /**
   * init the scrollable-plugin and set global vars
   * @author KM
   * @param boolean pCircular (should the slider slide "endless"?)
   */
  init: function(pCircular){
    //check, if we would an endless slide-show
    var lCircular = false; 
    if(pCircular !== undefined) {
      lCircular = true;
    }
    
    //init the plugin
    jQuery("#myscroll").scrollable({
      circular: lCircular
    });
   
    //init the global apiobject with the plugins-api-object
    LikeImageScroller.aApiObj = jQuery('#myscroll').data("scrollable");
  },
  
  /**
   * calls the scrollable api on scrolling thru the images
   * http://flowplayer.org/tools/documentation/scripting.html
   * @author KM
   */
  onScroll: function(){
    //on seek means on changing the showed image (like onscroll)
    LikeImageScroller.aApiObj.onSeek(function() {
      //update the counter
      LikeImageCounter.update(this.getIndex());
      //update the hidden image value into the form with the path of the current selected image
      WidgetLikeForm.setImageValue(LikeImage.getImgPath(this.getIndex()));
    });
  }
};


/**
 * Handles the behaviour of the image counter
 * @author KM
 */
var LikeImageCounter = {

  /**
   * sets the total number
   * @author KM 
   * @param number pCount
   */
  init: function(pCount) {
    jQuery('#img-number').empty();
    jQuery('#img-number').append(pCount);
  },
  
  /**
   * updates the counter, e.g. after scrolling
   * @author KM
   * @param number pCount
   */
  update: function(pCount) {
    jQuery('#img-counter').empty();
    jQuery('#img-counter').append(pCount+1);
  },
  
  /**
   * shows the counter-area (including the slide-arrows)
   * @author KM
   */
  show: function() {
    jQuery('#scroll-button-area').show();        
  },
  
  /**
   * hides the counter-area (including the slide-arrows)
   * @author KM
   */
  hide: function() {
    jQuery('#scroll-button-area').hide();        
  }
};