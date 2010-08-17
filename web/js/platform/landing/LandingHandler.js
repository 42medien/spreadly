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
				var id = this.id;
				var area_ids = Utils.explode('-', id);
				
				Utils.toggleTwoAreas(area_ids[0], area_ids[1]);
			});
			
			return false;
		}
		
}