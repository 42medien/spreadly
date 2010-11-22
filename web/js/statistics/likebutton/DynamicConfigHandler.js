/**
 * @combine statistics
 */


jQuery.fn.toggleClass = function(pFrom, pTo) {
  jQuery(this).removeClass(pFrom);
  jQuery(this).addClass(pTo);   
};



/**
 * Class for the dynamic configurator
 */
var DynamicConfig = {

  /**
   * inits the config-functionalities
   * @author KM
   */
  init: function() {
    debug.log("[DynamicConfig][init]");
    DynStyleForm.init();
    DynStyleWidgets.init();   
    DynStyleCode.init();
  },
  
  unbind: function() {
    debug.log("[DynamicConfig][unbind]");        
    jQuery('body').die('click.onbody');
  }
};


/**
 * Handles the behaviour of the config-form (eg. refresh widget and code on change of the form)
 * @author KM
 */
var DynStyleForm = {
  aFormfFields: {},    
  aTypeDD: {},  
  aCulture: "",  
  
  /**
   * inits the form-functions
   * @author KM
   */
  init: function() {
    debug.log("[DynStyleForm][init]");
    //set the user culture
    DynStyleForm.aCulture = ConfigWizard.aCulture;
    //reset the form on load in ff
    if (typeof(document.likebuttonform) !=  "undefined"){
      document.likebuttonform.reset();
    }    
    //bind the events to the form-fields and the body
    DynStyleForm.bindClicks();   
    //inits the type-dropdown
    DynStyleForm.initType();
    //init the colorpicker
    DynStyleForm.initColorpicker();
    //init the keynav-event for the url-field
    DynStyleForm.bindKeyNav();  
    //toggle the textfield-text
    jQuery('#likebutton_w').toggleValue();
    jQuery('#likebutton_fc').toggleValue(); 
    jQuery('#likebutton_url').toggleValue();       
  },  
  
  /**
   * bind the clicks to the config-forms
   * @param string pCulture
   * @author KM
   */
  bindClicks: function(pCulture) {
    debug.log("[DynStyleForm][bindClicks]");     
    //click for body element: the widgets and the code should refresh, if the form is changed
    jQuery('body').live("click.onbody", function(pEvent) {
      var lTarget = pEvent.target;
      var lTargetId = lTarget.id;
      //don't bind the click to the textfields->textfields, like url got his own keyup-event
      if(lTargetId != "likebutton_w" && lTargetId != 'likebutton_bt' && lTargetId != 'likebutton_sh' && lTargetId != 'likebutton_so' && lTargetId != 'likebutton_fc' && lTargetId != 'likebutton_url' && lTargetId != 'button-likebutton') {
        //check if something is new and update
        DynStyleWidgets.update();
      }
    });

    //hack for ie->it dont know the change-event
    var lEvent = 'change.typedd';
    if (jQuery.browser.msie) {
      lEvent = 'click.typedd';
    }
    
    //click for the select/option fields -> workaround for google chrome: officially you cant bind clicks to select options, so we need the change function
    jQuery('#likebutton_l, .likebutton_t, #likebutton_fc').live(lEvent, function() {
      if(this.id == 'likebutton_l'){
        //if the language is changed load the type dropdown in selected language
        DynStyleForm.changeType(this);
      }
      //check if something is new and update
      DynStyleWidgets.update();
    });

    //click for the checkbox: we need this, because if you bind this on the body-click the check don't work
    jQuery('#likebutton_bt, #likebutton_sh, #likebutton_so').live("click.checkbt", function() {
    //check if something is new and update
      DynStyleWidgets.update();
    });
  },
  
  /**
   * saves the formfields in a global var(object) -> initformfields
   * @author KM
   */  
  initFields: function() {
    debug.log("[DynStyleForm][initFields]");    
    //foreach formfield save value in object-key: fieldname
    jQuery.each(jQuery('#likebutton-form').serializeArray(), function(i, pField) {
      DynStyleForm.aFormfFields[pField.name] = pField.value;
    });
    // on default checkboxes aren't set, so set the checkbox-key and insert empty string
    if(jQuery('#likebutton_bt').attr('checked') === false) {
      DynStyleForm.aFormfFields['likebutton[bt]'] = '';
    }
    // on default checkboxes aren't set, so set the checkbox-key and insert empty string
    if(jQuery('#likebutton_sh').attr('checked') === false) {
      DynStyleForm.aFormfFields['likebutton[sh]'] = '';
    }
    // on default checkboxes aren't set, so set the checkbox-key and insert empty string
    if(jQuery('#likebutton_so').attr('checked') === false) {
      DynStyleForm.aFormfFields['likebutton[so]'] = '';
    }    
  },
  
  /**
   * caches the current state of the type dropdown
   * @author KM
   */
  initType: function() {
    debug.log("[DynStyleForm][initType]");                       
    jQuery('.likebutton_t').each(function(){
      DynStyleForm.aTypeDD[this.id] = this;
      if(this.id != 'type-'+DynStyleForm.aCulture) {
        jQuery(this).toggleClass('hide', 'show');
        jQuery(this).remove();
      }
    });    
  },
  
  /**
   * changes the dd-options if language is switched
   * @author KM
   */  
  changeType: function(pLangOption) {
    debug.log("[DynStyleForm][changeType]");
    
    //which lang is selected
    var lLanguage = jQuery('option:selected', pLangOption).val();
    //get the current dropdown
    var lCurrent = jQuery('.likebutton_t');
    //and look which field is selected in the type    
    var lCurrentType = jQuery('option:selected', lCurrent).val();
    //generate a new type-dropdown for the selected language
    var lNewDD = jQuery(DynStyleForm.aTypeDD['type-'+lLanguage]);
    jQuery(lCurrent).remove();    
    jQuery('#select-type').append(lNewDD);
    jQuery(lNewDD).val(lCurrentType).attr("selected", "selected");       
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
        DynStyleWidgets.update();
      }, 500);
    });    
  },

  /**
   * checks, if something is changed in the form
   * @author KM
   */
  checkIsNew: function() {
    debug.log("[DynStyleForm][checkIsNew]");    
    //get the current field in an array
    var lFormFields = jQuery('#likebutton-form').serializeArray();
    //if checkbox is not checked
    if(jQuery('#likebutton_bt').attr('checked') === false) {
      //make a new object for checkbox and push it to the form-fields-array
      var lObject = {};
      lObject.name = 'likebutton[bt]';
      lObject.value = '';
      lFormFields.push(lObject);
    }
    if(jQuery('#likebutton_sh').attr('checked') === false) {
      //make a new object for checkbox and push it to the form-fields-array
      var lObject = {};
      lObject.name = 'likebutton[sh]';
      lObject.value = '';
      lFormFields.push(lObject);
    }
    if(jQuery('#likebutton_so').attr('checked') === false) {
      //make a new object for checkbox and push it to the form-fields-array
      var lObject = {};
      lObject.name = 'likebutton[so]';
      lObject.value = '';
      lFormFields.push(lObject);
    }

    //check now if there are some differences between the last formfields and the formfield after click
    for(var i=0; i<lFormFields.length; i++) {
      //debug.log('field: '+lFormFields[i].name);
      //debug.log('saved: '+ConfigStyle.aFormfFields[lFormFields[i].name]);
      //debug.log('actuall: '+lFormFields[i].value);
      if(DynStyleForm.aFormfFields[lFormFields[i].name] != lFormFields[i].value) {
        DynStyleForm.initFields();
        return true;
      }
    }
    return false;    
    
  },
  
  /**
   * inits the options for the colorpicker-plugin
   * @author http://www.eyecon.ro/colorpicker/
   */
  initColorpicker: function() {
    debug.log("[DynStyleForm][initColorpicker]");               
    var fontoptions = {
      onSubmit:  function(hsb, hex, rgb, el) {
        jQuery(el).val('#'+hex);
        jQuery(el).ColorPickerHide();
      },
      onBeforeShow: function() {
        jQuery(this).ColorPickerSetColor('#000000');
      },
      onChange: function(hsb, hex, rgb) {
        jQuery('#likebutton_fc').val('#'+hex);    
      }
    };
    jQuery('#likebutton_fc').ColorPicker(fontoptions);
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
    DynStyleCode.get();  
  },
  
  /**
   * sends the request to get the updated widgets
   * @author KM
   */
  update: function(){
    debug.log("[DynStyleWidgets][update]");         
    //if there are changes in the form or the user clicked the generate-button: send a request to get the changed widget
    if(DynStyleForm.checkIsNew() === true) {
      var options = {
          url:       '/likebutton/get_button',
          data: { ei_kcuf: new Date().getTime() },
          type:      'GET',
          dataType:  'json',
          //resetForm: lReset,
          success:   function(pResponse) {DynStyleWidgets.show(pResponse);}
      };
      jQuery('#likebutton-form').ajaxSubmit(options);
    }    
  },
  
  /**
   * postload the widgets (used after side-reload...)
   * @author KM
   */
  postload: function() {
    debug.log("[DynStyleWidgets][updateWidget]");         
    //if there are changes in the form or the user clicked the generate-button: send a request to get the changed widget
    var options = {
        url:       '/statistics_dev.php/likebutton/get_button',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {DynStyleWidgets.show(pResponse); DynStyleForm.initFields(); }
    };
    jQuery('#likebutton-form').ajaxSubmit(options);    
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
    DynStyleCode.aClipFlashPath = ConfigWizard.aClipFlashPath;
    ZeroClipboard.setMoviePath(DynStyleCode.aClipFlashPath);
    debug.log(DynStyleCode.aClipFlashPath);    
    DynStyleCode.initClipboard();  
  },    
    
  /**
   * sends request to get the updated button code after form-editing
   * @author KM
   */
  get: function(){
    debug.log("[DynStyleCode][get]");     
    var options = {
        url:       '/likebutton/get_buttoncode',
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
      /*
      lClip.addEventListener('complete', function(client, text) {
        jQuery('#button_get_code_outer').animate({"background-color": "#aaa"}, 2000);
        //alert('done');
      });*/
      //lClip.setCSSEffects( true )
      //lClip.setHandCursor( true );
      lClip.glue('button_get_code_outer');
    } else {
      //if not right flash version: hide the button
      jQuery('#button_get_code_outer').hide();
    }
  }  
};