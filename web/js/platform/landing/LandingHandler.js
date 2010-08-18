/**
 * @combine platform
 */
 
 
 
/**
 * Class to handle global landing effects
 * @author Christian Schätzle
 * @version 1.0
 */
var Landing = {
		
		init: function() {
			Landing.toggleLoginAreas();
		},
		
		/**
	   * @description toggles between the two login areas
	   */  
		toggleLoginAreas: function() {
			
			jQuery('.toggle_login_area').live("click", function() {
				
				var lParams = jQuery(this).attr('data-obj');
				lParams = jQuery.parseJSON(lParams);
				
				ElementHandler.toggleTwoAreas(lParams.from_id, lParams.to_id);
				
				return false;
			});
		}
		
};