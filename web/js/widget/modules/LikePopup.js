/**
 * @combine likepopup
 */

/**
 * Generel scripts for the like-settings-popup
 * @author Karina Mies
 */
var LikePopup = {
	
	aOpener: null,
	
	/**
	 * inits the global vars and main functions
	 * @author Karina Mies
	 */
	init: function() {
    LikePopup.aOpener = window.opener;
    if(LikePopup.aOpener == undefined || LikePopup.aOpener == null) {
      LikePopup.aOpener = opener;
    }	
    LikePopup.closePopup();	
	},
	
  /**
   * close the popup on click
   * @author Karina Mies
   */
  closePopup: function() {
		jQuery('#cancel-link').live('click', function() {
    window.close();     
		});
	},
	
  /**
   * refreshs the opener window (the widget)
   * @author Karina Mies
   */
	refreshParent: function() {
    LikePopup.aOpener.location.reload();		
	}
};

/**
 * scripts to show help/info
 * @author Karina Mies
 */
var PopupInfo = {
	
  /**
   * inits the mouseover/out functionality
   * @author Karina Mies
   */	
	initHover: function() {
    jQuery('#show_help').live('mouseover', function() {
    	jQuery('#help_area').show();
    });
    
    jQuery('#show_help').live('mouseout', function() {
      jQuery('#help_area').hide();
    });    
    
	}
}