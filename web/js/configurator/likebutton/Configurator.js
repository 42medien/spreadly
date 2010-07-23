/**
 * @combine configurator
 */

jQuery.fn.toggleValue = function(){
	var lText = jQuery(this).val();
	var lNewText = '';
	jQuery(this).bind('click', function() {
		lNewText = jQuery(this).val();
		if(lNewText == lText){
      jQuery(this).val('');
    }
	});

	jQuery(this).blur(function(){
    lNewText = jQuery(this).val();
    if(lNewText == '') {
		  jQuery(this).val(lText);
    }
	});
};


jQuery.fn.toggleClass = function(pFrom, pTo) {
  jQuery(this).removeClass(pFrom);
  jQuery(this).addClass(pTo);		
};


/**
 * class for configurator-app
 * @author KM
 */
var Configurator = {

  aFormfFields: {},
  aFrameCode: '',
  aEmail: '',
  aTypeDD: {},

	/**
	 * inits the configurator functionalities
	 * @author KM
	 * @param string pCulture (current user culture)
	 */
  init: function(pCulture) {
    Configurator.bindClicks();
    Configurator.initFormFields();
    document.likebuttonform.reset();
    Configurator.initColorpicker();
    Configurator.initType(pCulture);
  },

  /**
   * saves the formfields in a global var(object)
   * @author KM
   */
  initFormFields: function() {
    //foreach formfield save value in object-key: fieldname
    jQuery.each(jQuery('#likebutton-form').serializeArray(), function(i, pField) {
      Configurator.aFormfFields[pField.name] = pField.value;
    });
    // on default checkboxes aren't set, so set the checkbox-key and insert empty string
    if(jQuery('#likebutton_bt').attr('checked') === false) {
      Configurator.aFormfFields['likebutton[bt]'] = '';
    }
  },

  /**
   * checks, if something is changed in the form
   * @author KM
   */
  checkIsNew: function() {
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

    //check now if there are some differences between the last formfields and the formfield after click
    for(var i=0; i<lFormFields.length; i++) {
      if(Configurator.aFormfFields[lFormFields[i].name] != lFormFields[i].value) {
        Configurator.initFormFields();
        return true;
      }
    }
    return false;
  },

  /**
   * binds the clicks to body and the form-elements
   * @author KM
   */
  bindClicks: function() {
    //click for body element
    jQuery('body').live("click.onbody", function(pEvent) {
      var lTarget = pEvent.target;
      var lTargetId = lTarget.id;
      //don't bind the click to the textfields and the generate-button
      if(lTargetId != "likebutton_url" && lTargetId != "likebutton_w" && lTargetId != 'likebutton_bt' && lTargetId != 'likebutton_email' && lTargetId != 'likebutton_fc') {
        Configurator.updateWidget();
      }
    });

    //click for the select/option fields -> workaround for google chrome: officially you cant bind clicks to select options, so we need the change function
    jQuery('#likebutton_l, .likebutton_t, #likebutton_fc').live('change', function() {
      if(this.id == 'likebutton_l'){
      	Configurator.changeType(this);
      	Configurator.updateWidthLabel(jQuery('.likebutton_t'), this);
      }
      
      if(jQuery(this).hasClass('likebutton_t')) {
      	Configurator.updateWidthLabel(this, jQuery('#likebutton_l'));
      }
      
      Configurator.updateWidget();
    });

    //click for the checkbox: we need this, because if you bind this on the body-click the check don't work
    jQuery('#likebutton_bt').live("click.checkbt", function() {
      Configurator.updateWidget();
    });

    //click for the generate-button. the updateWidget-func needs a param that we know, that the generate was clicked
    jQuery('#button-likebutton').live('click.generate', function(){
      Configurator.updateWidget('generate');
      return false;
    });

    jQuery('#likebutton_w').toggleValue();
    jQuery('#likebutton_email').toggleValue();
    jQuery('#likebutton_fc').toggleValue();    
  },

  /**
   * updates the like-button-widget if there are some changes in the form
   * @author KM
   * @param string pState
   */
  updateWidget: function(pState) {
    //if there are changes in the form or the user clicked the generate-button: send a request to get the changed widget
    if(Configurator.checkIsNew() === true || (pState == 'generate')) {
      var options = {
          url:       '/likebutton/get_button',
          data: { ei_kcuf: new Date().getTime() },
          type:      'GET',
          dataType:  'json',
          //resetForm: lReset,
          success:   function(pResponse) {Configurator.showWidget(pResponse, pState);}
      };
      jQuery('#likebutton-form').ajaxSubmit(options);
    }
  },

  /**
   * callback to handle the response after updateWidget
   * @author KM
   * @param object pResponse
   * @param string pState
   */
  showWidget: function(pResponse, pState) {
    //remove the current widget
    jQuery('#yiid-widget').empty();
    //and append the new one
    jQuery('#yiid-widget').append(pResponse.iframe);
    //save the frame code in the global variable (we need this, that we can show the code every time)
    Configurator.aFrameCode = pResponse.iframe;
    //save the value of the email-field (we need this, that we can send the request for newsletter after click on generate)
    Configurator.aEmail = pResponse.email;
    //if the user clicked the button, opens the facebox, show the code and check, if the user will get the newsletter
    if(pState == 'generate'){
      Configurator.showCode();
      Configurator.sendEmail();
    }
  },

  /**
   * opens the facebook with the code and current settings after click generate
   * @author KM
   */
  showCode: function() {
    jQuery.facebox('<textarea name="iframe-code" cols="50" rows="10" id="iframe-code-textarea" >'+Configurator.aFrameCode+'</textarea>');
  },

  /**
   * send the email-address to action, which check, if the user wanna get the newsletter
   * @author KM
   */
  sendEmail: function() {
    var options = {
      email: Configurator.aEmail,
      ei_kcuf: new Date().getTime()
    };
    jQuery.ajax({
      type: "POST",
      url: '/likebutton/send_email',
      dataType: "json",
      data: options,
      success: function (response) {
        return false;
      }
    });
  },
  
  /**
   * inits the options for the colorpicker-plugin
   * @author http://www.eyecon.ro/colorpicker/
   */
  initColorpicker: function() {
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
  },
  
  /**
   * toggles the textareas with the generic code
   * @author Christian Schätzle
   * @param int pValue
   */
  toggleGenericCode: function(pValue) {
  	if(pValue == 0) {
  		jQuery('#generic_code_like_dislike').hide();
  		jQuery('#generic_code_like').show();
  	} else if (pValue == 1) {
  		jQuery('#generic_code_like').hide();
  		jQuery('#generic_code_like_dislike').show();
		}
  	return false;
  },
  
  /**
   * inits the global type-var with the dropdown-objects for type (every language one option-list) and remove the current not used from dom
   * @author KM
   * @param string pCulture
   */
  initType: function(pCulture) {
    jQuery('.likebutton_t').each(function(){
      Configurator.aTypeDD[this.id] = this;
      if(this.id != 'type-'+pCulture) {
        jQuery(this).toggleClass('hide', 'show');
        jQuery(this).remove();
      }
    });
  },  
  
  /**
   * actualize the type-dropdown to the selected language
   * @author KM
   * @param object pLangOption
   */
  changeType: function(pLangOption) {
    var lLanguage = jQuery('option:selected', pLangOption).val();
    var lCurrent = jQuery('.likebutton_t');
    var lCurrentType = jQuery('option:selected', lCurrent).val();
    var lNewDD = jQuery(Configurator.aTypeDD['type-'+lLanguage]);
    jQuery(lCurrent).remove();    
    jQuery('#select-type').append(lNewDD);
    jQuery(lNewDD).val(lCurrentType).attr("selected", "selected");    
  },
  
  updateWidthLabel: function(pTypeOption, pLanguageOption) {
  	var lType = jQuery('option:selected', pTypeOption).val();
  	var lLanguage = jQuery('option:selected', pLanguageOption).val();
  	
  	if(jQuery('#likebutton_bt').attr('checked') === false) {
  		var lGlobalType = 'like';
  	} else {
  		var lGlobalType = 'full';
  	}
  	
  	jQuery.ajax({
      type: "POST",
      url: '/likebutton/update_width_label',
      data: { fuck_ie: new Date().getTime(), type: lType, lang: lLanguage, global_type: lGlobalType },
      dataType: "json",
      success: function (response) {
        jQuery('#width_value').empty();
        jQuery('#width_value').html(response.html);
      	return false;
      }
    });
  }
};