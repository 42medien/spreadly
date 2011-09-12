/**
 * @combine widget
 */

/**
 * Handles the sending of the like
 * @author KM
 */


var WidgetLikeForm = {
   
    send: function() {
      debug.log("[WidgetLikeForm][send]");      
      jQuery('#popup-like-button').live('click', function() {
        WidgetLikeForm.beforeSend();
        document.forms['popup-like-form'].submit();
        
        return false;
      });
      
    },
    
    beforeSend: function(){
      debug.log("[WidgetLikeForm][beforeSend]");        
      OnLoadGrafic.showGrafic();
      jQuery('#like-oi-list').hide();   
      jQuery('#popup-like-button').hide();
    },
    
    /**
     * sets the hidden img-value
     * @author KM
     * @param string pPath
     */
    setImageValue: function(pPath){
      jQuery('#like-img-value').val(pPath);
    }
};


/**
 * Handles the behaviour/settings of the preview image for like-messages in services
 * @author KM
 */
var LikeImage = {

    init: function(pImgCount, pUrl) {
     debug.log("[LikeImage][init]");
     debug.log(pImgCount);
     if(pImgCount == 0) {
        LikeImage.get(pUrl);
     } else if (pImgCount == 1) {
       WidgetLikeForm.setImageValue(LikeImage.getImgPath(0));
       LikeImageCounter.hide();
     } else {
       LikeImageScroller.init(true);
       LikeImageCounter.init(pImgCount);
       LikeImageCounter.show();
       LikeImageScroller.onScroll();
     }
    },

    /**
     * if there is no image given by the meta-tag-parser, try to get some from the html-content from the given url
     * @author KM
     * @param string pUrl
     */
    get: function(pUrl) {
      debug.log("[LikeImage][get]");
      OnLoadGrafic.insertGraficToElem(jQuery('#myscroll'));
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
      debug.log("[LikeImage][handleResponse]");      
      //insert the image into slider-container
      LikeImage.insert(pResponse.html);
      //if there is no or 1 image, hide the slide-arrows and the counter
      debug.log(pResponse.count);
      if(pResponse.count === 0 || pResponse.count === 1){
        //LikeImageCounter.hide();
        LikeImageScroller.hideContainer();
      } else {
        // if there are more than 1 images:
        // init the scroller
        LikeImageScroller.init(true);
        //init the counter
        //LikeImageCounter.init(pResponse.count);
        //show the slide-arrows and the counter
        //LikeImageCounter.show();
        //and init the onscroll-functionalities (e.g. update counter & update hidden-img-value onscroll)
        LikeImageScroller.onScroll();
      }

      //fill the hidden-img-value with the path of the first image
      WidgetLikeForm.setImageValue(LikeImage.getImgPath(0));
      OnLoadGrafic.removeGraficFromElem(jQuery('#myscroll'));
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
    
    LikeImageScroller.showContainer();
    
    //check, if we would an endless slide-show
    var lCircular = false;
    if(pCircular !== undefined) {
      lCircular = true;
    }

    //init the plugin
    jQuery("#myscroll").scrollable({
      //circular: true
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
  },
  
  showContainer: function() {
    jQuery('#scroll-button-area').show();    
    
  },

  hideContainer: function() {
    jQuery('#scroll-button-area').hide();
  }


};


/**
 * Handles the behaviour of the image counter
 * @author KM
 * @depricated not in use anymore
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

var WidgetLikeContent = {

  aIsContent: false,

  get: function(){
    debug.log('[WidgetLikeContent][get]');
    OnLoadGrafic.showGrafic();
    jQuery('#man-url-content').empty();
    jQuery.ajax({
      //beforeSubmit : OnLoadGrafic.showGrafic,
      type :     "GET",
      url:       '/like/get_like_content',
      dataType : "json",
      data: {
        ei_kcuf: new Date().getTime(),
        url: jQuery('#man-url-input').val()
      },
      success : function(pResponse) {
        if(pResponse.success == true) {
          WidgetLikeContent.show(pResponse.html);
          //WidgetLikeContent.aIsContent = true;
          LikeImage.init(pResponse.imgcount, pResponse.url);
          WidgetLikeForm.init();
        } else {
          //if(WidgetLikeContent.aIsContent === false) {
            WidgetLikeContent.showError(pResponse.msg);
          //}
          //OnLoadGrafic.hideGrafic();
        }
      }
    });
  },

  show: function(pHtml) {
    debug.log('[WidgetLikeContent][show]');
    //WidgetLikeContent.aIsContent = false;
    jQuery('#man-url-content').empty();
    jQuery('#man-url-content').append(pHtml);
    OnLoadGrafic.hideGrafic();
  },

  showError: function(pMsg){
    debug.log('[WidgetLikeContent][showError]');
    jQuery('#man-url-content').empty();
    jQuery('#man-url-content').prepend("<div class='error'>"+pMsg+"</div>");
    OnLoadGrafic.hideGrafic();
  }
};

var WidgetAddService = {
  init:function(){
  	debug.log('[WidgetAddService][init]');
    WidgetAddService.bindClick();
  },

  bindClick: function() {
    jQuery('#like-oi-list .add-service-checkbox').live('click', function() {
      OnLoadGrafic.showGrafic();
      jQuery("body").css("cursor", "progress");
      var lService = jQuery(this).val();
      WidgetAddService.redirect(lService);
    });
  },

  redirect: function(pService){
    window.location = '/auth/signinto?service='+pService;
  }

};