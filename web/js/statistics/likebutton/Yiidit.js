/**
 * @combine statistics
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
		jQuery('#signin_username').toggleValue();
		jQuery('#signin_password').toggleValue();
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
  }
};