/**
 * @combine widget
 */

/**
 * Handles the sending of the like
 * @author KM
 */


var WidgetLikeForm = {
   
    /**
     * sends the form to the action defined in form
     * @author KM
     */
    send: function() {
      debug.log("[WidgetLikeForm][send]");      
      jQuery('#popup-like-button').live('click', function() {
        WidgetLikeForm.beforeSend();
        document.forms['popup-like-form'].submit();
        return false;
      });
    },
    
    /**
     * Hides the button-area after clicking the like-button (so that the user can't click twice) and shows the loading-icon
     * @author KM
     */
    beforeSend: function(){
      debug.log("[WidgetLikeForm][beforeSend]");        
      OnLoadGrafic.showGrafic();
      jQuery('#like-oi-list').hide();   
      jQuery('#popup-like-button').hide();
    },
    
    /**
     * sets the hidden img-value by selecting an image with the image scroller
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
     if(pImgCount == 0) {
        LikeImage.get(pUrl);
     } else if (pImgCount == 1) {
       WidgetLikeForm.setImageValue(LikeImage.getImgPath(0));
       //LikeImageCounter.hide();
     } else {
       LikeImageScroller.init(true);
       //LikeImageCounter.init(pImgCount);
       //LikeImageCounter.show();
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
      if(pResponse.count === 0 || pResponse.count === 1){
        //LikeImageCounter.hide();
        LikeImageScroller.hideContainer();
      } else {
        // if there are more than 1 images: init the scroller
        LikeImageScroller.init(true);
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
     // LikeImageCounter.update(this.getIndex());
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
 * inline-add for the services the user want to share
 */
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
  },
  
  reloadServices: function() {
    OnLoadGrafic.hideGrafic();
    jQuery('#like-submit').empty();
    var lAction = '/like/get_services';
    var lData = {
        ei_kcuf : new Date().getTime(),
      };

    jQuery.ajax({
      type : "GET",
      url : lAction,
      dataType : "json",
      data : lData,
      success : function(pResponse) {
        jQuery('#like-submit').append(pResponse.services);
        if(!jQuery('#nav-username').length){
          jQuery('footer').empty();
          jQuery('footer').append(pResponse.footer);
        }
        OnLoadGrafic.hideGrafic();
      }
    });    
  }

};