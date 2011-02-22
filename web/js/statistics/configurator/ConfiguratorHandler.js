/**
 * @nocombine statistics
 */

var Configurator = {
    
  aCulture: "",  
  aClipFlashPath: "",    
  
  init: function(pClipFlashPath) {
    debug.log('[Configurator][init]');
    Configurator.aClipFlashPath = pClipFlashPath;    
    Configurator.chooseApp();
    //DynStyleCode.init();  
    //DynStyleWidgets.init();    
  },
  
  initFormFx: function() {
    jQuery("select.custom-select").jgdDropdown({
      callback: function() {
        DynStyleCode.get();
        DynStyleWidgets.update();
      }
    });
    jQuery("input[type='radio']").custCheckBox({
      callback: function() {
        DynStyleCode.get();
        DynStyleWidgets.update();
      }
    });      
  },
  
  chooseApp: function() {
    debug.log("[Configurator][chooseApp]");      
    jQuery('.config-app-link').live('click', function() {
      var lAction = jQuery(this).attr('href');
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        success: function (response) {
          jQuery('#choose-style-container').empty();
          jQuery('#choose-style-container').html(response.html);
          DynStyleCode.get();
          DynStyleWidgets.init();
          DynStyleForm.init();
          Configurator.initFormFx();  
          DynStyleCode.init();
        }
      });
      return false;
    });     
  }
};


/**
 * class to handle the code in the textarea
 * @author KM
 */
var DynStyleCode = {
  
  /**
   * var to save the path for the copy to clipboard-swf
   */
  aClipFlashPath: "",    
    
  /**
   * inits the special code functionalities
   * @author KM
   */
  init: function() {
    debug.log("[DynStyleCode][init]");     
    DynStyleCode.aClipFlashPath = Configurator.aClipFlashPath;
    ZeroClipboard.setMoviePath(DynStyleCode.aClipFlashPath);
    DynStyleCode.initClipboard();  
  },    
    
  /**
   * sends request to get the updated button code after form-editing
   * @author KM
   */
  get: function(){
    debug.log("[DynStyleCode][get]");     
    var options = {
        url:       '/configurator/get_buttoncode',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) { DynStyleCode.show(pResponse); }
    };
    jQuery('#likebutton-form').ajaxSubmit(options);   
  },
  
  /**
   * inserts the updated button code into the textarea
   * @author KM
   * @param json pResponse
   */
  show: function(pResponse) {
    debug.log("[DynStyleCode][show]");
    jQuery('#your_code').empty();
    jQuery('#your_code').val(pResponse.iframe);    
  },
  
  /**
   * inits the copy to clipboard functionality
   * @author KM
   */
  initClipboard: function() {
    debug.log("[DynStyleCode][initClipboard]");   
    
    //get the users flash-version
    var lPlayerVersion = swfobject.getFlashPlayerVersion();
    //jQuery.fx.off = true;
    //if the version is greater than 10, show the button and add the ctc-functionality
    if(lPlayerVersion.major >= 10) {
      var lClip = new ZeroClipboard.Client();
      lClip.addEventListener('mouseOver', function(client){
        lClip.setText(jQuery('#your_code').val());      
      });
      lClip.setHandCursor( true );
      lClip.setCSSEffects( true );
      lClip.glue( 'd_clip_button', 'd_clip_container');
    } else {
      //if not right flash version: hide the button
      jQuery('#d_clip_container').hide();
    }
    jQuery('#d_clip_container').live('click', function() {
      return false;
    });    
  }  
};

/**
 * handles the preview-widgets
 * @author KM
 */
var DynStyleWidgets = {
    
  /**
   * inits special-widget functionalities
   * @author KM
   */
  init: function() {
    debug.log('[DynStyleWidgets][init]');    
    DynStyleWidgets.postload();  
  },    
    
  /**
   * show the widget after request
   * @author KM
   */
  show: function(pResponse) {
    debug.log("[DynStyleWidgets][show]");       
    //remove the current widget
    jQuery('#preview_widgets').empty();
    //and append the new one
    jQuery('#preview_widgets').append(pResponse.iframe);  
  },
  
  /**
   * sends the request to get the updated widgets
   * @author KM
   */
  update: function(){
    debug.log("[DynStyleWidgets][update]");         
    //if there are changes in the form or the user clicked the generate-button: send a request to get the changed widget
      var options = {
          url:       '/configurator/get_button',
          data: { ei_kcuf: new Date().getTime() },
          type:      'GET',
          dataType:  'json',
          //resetForm: lReset,
          success:   function(pResponse) {DynStyleWidgets.show(pResponse);}
      };
      jQuery('#likebutton-form').ajaxSubmit(options);
      return false;
  },
  
  /**
   * postload the widgets (used after side-reload...)
   * @author KM
   */
  postload: function() {
    debug.log("[DynStyleWidgets][postload]");         
    //if there are changes in the form or the user clicked the generate-button: send a request to get the changed widget
    var options = {
        url:       '/configurator/get_button',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {DynStyleWidgets.show(pResponse);}
    };
    jQuery('#likebutton-form').ajaxSubmit(options);    
  }
    
};

var DynStyleForm = {
  init: function() {
    debug.log("[DynStyleForm][init]");       
    DynStyleForm.bindKeyNav();
    
  },
  
  /**
   * updates widgets after typing a url
   * @author KM
   */   
  bindKeyNav: function() {
    debug.log("[DynStyleForm][bindKeyNav]");       
    var lTimeout;
    jQuery('#likebutton_url').keyup(function(e) {
      clearTimeout(lTimeout);
      lTimeout = setTimeout(function() {
        DynStyleCode.get();
        DynStyleWidgets.update();
      }, 500);
    });    
  } 
};