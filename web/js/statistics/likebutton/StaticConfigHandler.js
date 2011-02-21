/**
 * @nocombine statistics
 */

var StaticConfig = {
    
  /**
   * inits the static configurator
   * 
   * @author KM
   * @param string pCulture
   */    
  init: function(pCulture) {
    debug.log("[StaticConfig][init]");
    StatStyleForm.init();
    StatStyleCode.init();    
  },
  
  unbind: function() {
    debug.log("[StaticConfig][unbind]");    
    jQuery('body').die('click.onbody');
  }  
  
};

/**
 * Class for the handling of the static-config-form
 * @author KM
 */
var StatStyleForm = {
    
  /**
   * array to cache the last form settings
   */
  aFormfFields: {}, 
    
  /**
   * inits the config-form
   * @author KM
   */
  init: function() {    
    debug.log("[StatStyleForm][init]");  
    StatStyleForm.bindClicks();
    StatStyleForm.bindKeyNav();
    jQuery('#static_button_url').toggleValue();
    jQuery('#static_button_text_value').toggleValue();  
  },
  
  /**
   * saves the formfields in a global var(object) -> initformfields
   * @author KM
   */  
  initFields: function() {
    debug.log("[StatStyleForm][initFields]");    
    //foreach formfield save value in object-key: fieldname
    jQuery.each(jQuery('#staticbutton-form').serializeArray(), function(i, pField) {
      StatStyleForm.aFormfFields[pField.name] = pField.value;
    });
    // on default checkboxes aren't set, so set the checkbox-key and insert empty string
    if(jQuery('#staticbutton_bt').attr('checked') === false) {
      StatStyleForm.aFormfFields['static_button[bt]'] = '';
    } 
  },
  
  /**
   * checks, if something is changed in the form
   * @author KM
   */
  checkIsNew: function() {
    debug.log("[StatStyleForm][checkIsNew]");    
    //get the current field in an array
    var lFormFields = jQuery('#staticbutton-form').serializeArray();
    //if checkbox is not checked
    if(jQuery('#staticbutton_bt').attr('checked') === false) {
      //make a new object for checkbox and push it to the form-fields-array
      var lObject = {};
      lObject.name = 'static_button[bt]';
      lObject.value = '';
      lFormFields.push(lObject);
    }

    //check now if there are some differences between the last formfields and the formfield after click
    for(var i=0; i<lFormFields.length; i++) {
      if(StatStyleForm.aFormfFields[lFormFields[i].name] != lFormFields[i].value) {
        StatStyleForm.initFields();
        return true;
      }
    }
    return false;    
  },
  
  /**
   * bind the clicks to the config-forms
   * @param string pCulture
   * @author KM
   */
  bindClicks: function(pCulture) {
    debug.log("[StatStyleForm][bindClicks]");     
    //click for body element: the widgets and the code should refresh, if the form is changed
    jQuery('body').live("click.onbody", function(pEvent) {
      var lTarget = pEvent.target;
      var lTargetId = lTarget.id;
      //don't bind the click to the textfields->textfields, like url got his own keyup-event
      if(lTargetId != 'staticbutton_bt' && lTargetId != 'static_button_text_value' && lTargetId != 'static_button_url' && lTargetId != 'button-likebutton' && lTargetId != 'staticbutton_l') {
        StatStyleForm.update();
      }
    });

    //click for the select/option fields -> workaround for google chrome: officially you cant bind clicks to select options, so we need the change function
    jQuery('#staticbutton_l').live('change', function(pEvent) {
      StatStyleForm.update();
      //StatStyleText.update(pCulture);
      StatStyleText.update(jQuery('#staticbutton_l').val());
      //debug.log(jQuery('#staticbutton_l').val());
      //jQuery('#static_button_text_value').toggleValue();  
    });
    
    //set text-radio to checked if user type in textfield
    jQuery('#static_button_text_value').live("focus", function() {
      jQuery('#static_button_text_radio').attr("checked","checked");
      StatStyleForm.update();
    });    

    //click for the checkbox: we need this, because if you bind this on the body-click the check don't work
    jQuery('#staticbutton_bt').live("click.checkbt", function() {
    //check if something is new and update
      StatStyleForm.update();
    });
  },
  
  /**
   * if user types in textfield make code-update after timeout
   * @author KM
   */
  bindKeyNav: function() {
    debug.log("[StatStyleForm][bindKeyNav]");       
    var lTimeout;
    jQuery('#static_button_url, #static_button_text_value').keyup(function(e) {
      clearTimeout(lTimeout);
      lTimeout = setTimeout(function() {
        StatStyleForm.update();
      }, 500);
    });    
  },  
  
  /**
   * send the request for updating the form
   * @author KM
   */
  update: function() {
    debug.log("[StatStyleForm][update]");       
    if(StatStyleForm.checkIsNew() === true) {
      //StatStyleText.update(jQuery('#staticbutton_l').val());   
      var options = {
          url:       '/likebutton/get_static_code',
          data: { ei_kcuf: new Date().getTime() },
          type:      'GET',
          dataType:  'json',
          //resetForm: lReset,
          success:   function(pResponse) {
            if(pResponse.codetype == 'img') {
              StatStyleCode.update(pResponse.imgcode);              
            } else {
              StatStyleCode.update(pResponse.textcode);
            }
            StatStyleButton.update(pResponse.imgcode);
            StatStyleForm.initFields(); 
          }
      };
      jQuery('#staticbutton-form').ajaxSubmit(options);
    }    
  }
};

/**
 * Class to handle the static-image-button
 * @author KM
 */
var StatStyleButton = {
  
  /**
   * updates the static-button-preview
   * @author KM
   */
  update: function(pCode) {
    debug.log("[StatStyleButton][update]"); 
    jQuery('#static-button-preview').empty();
    jQuery('#static-button-preview').append(pCode);     
  }
};

/**
 * Class to handle the variable text of the static link
 * @author KM
 */
var StatStyleText = {
  
  /**
   * updates the textfield by culture
   * @author KM
   * @param string pCulture
   */
  update: function(pCulture) {
    debug.log("[StatStyleText][update]");
    jQuery('#static_button_text_value').val(i18n.get('like_'+pCulture));
    jQuery('#static_button_text_value').toggleValue();    
  }
};

/**
 * Class to handle the code-area in static config
 * @author KM
 */
var StatStyleCode = {
    
  aClipFlashPath: "",  
  
  init: function(){
    debug.log("[StatStyleCode][init]");    
    StatStyleCode.aClipFlashPath = ConfigWizard.aClipFlashPath;
    ZeroClipboard.setMoviePath(StatStyleCode.aClipFlashPath);
    StatStyleCode.initClipboard();   
  },
    
  /**
   * updates the static-button-preview
   * @author KM
   */    
  update: function(pCode) {
    debug.log("[StatStyleCode][update]"); 
    jQuery('#your_static_code').empty();
    jQuery('#your_static_code').val(pCode);        
  },
  
  /**
   * inits the copy to clipboard functionality
   * @author KM
   */
  initClipboard: function() {
    debug.log("[StatStyleCode][initClipboard]");   
    //get the users flash-version
    var lPlayerVersion = swfobject.getFlashPlayerVersion();
    //if the version is greater than 10, show the button and add the ctc-functionality
    if(lPlayerVersion.major >= 10) {
      var lClip = new ZeroClipboard.Client();
      lClip.addEventListener('mouseOver', function(client){
        debug.log(jQuery('#your_static_code').val());
        lClip.setText(jQuery('#your_static_code').val());      
      });
      /*
      lClip.addEventListener('complete', function(client, text) {
        jQuery('#button_get_code_outer').animate({"background-color": "#aaa"}, 2000);
        //alert('done');
      });*/
      //lClip.setCSSEffects( true )
      //lClip.setHandCursor( true );
      lClip.glue('button_get_stat_code_outer');
    } else {
      //if not right flash version: hide the button
      jQuery('#button_get_stat_code_outer').hide();
    }
  }   
};