/**
 * @combine configurator
 */

/**
 * class for yiid it-app
 * @author KM
 */
var Yiidit = {
	/**
	 * inits the yiid it functionalities
	 * @author KM
	 */
	init: function() {
		Yiidit.toggleAreas();
		Yiidit.chooseAnyWebsite();
    Configurator.initColorpicker();
  },
  
  /**
   * toggles the benefit areas on yiid it
   * @author Christian Schätzle
   */
  toggleAreas: function() {
  	jQuery('.toggle-benefits').live('click', function() {
  		// check if selected benefit is already open
  		var id = this.id;
  		var display = jQuery('#benefits_'+id).css('display');
  		
  		// hide all benefits
  		jQuery('.benefits').hide();
  		
  		// and show the selected one. If it is already open hide it
  		if(display == 'block') {
  			jQuery('#benefits_'+id).hide();
  		} else {
  			jQuery('#benefits_'+id).show();
  		}
  		
  		return false;
  	});
  },
  
  chooseAnyWebsite: function() {
  	jQuery('.choose_any_website').live('click', function() {
  		jQuery.ajax({
        type: "GET",
        url: '/likebutton/get_choose_style',
        dataType: "json",
        success: function (response) {
  				jQuery('#main_area_content').empty();
  				jQuery('#main_area_content').html(response.html);
        }
      });
  		
      return false;
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
  }
};