/**
 * @nocombine platform
 */



var ClassHandler = {
	
	setClassByElement: function(pElement, pClass) {
		jQuery(pElement).addClass(pClass);
	},
	
	removeClassByElement: function(pElement, pClass) {
    jQuery(pElement).removeClass(pClass);		
	},
	
  removeClassesByParent: function(pParent, pClass) {
    jQuery(pParent).children('.'+pClass).removeClass(pClass);          
  }	
}


/**
  * ListHandler: Helper-Object to handle general list operations
  * @author KM
  * @version 1.0
  */
var ListHandler = {
	
	toggleClassById: function(pItemId, pClass) {
		var lElement = jQuery('#'+pItemId);
		jQuery(lElement).siblings('li').removeClass(pClass);
		jQuery(lElement).addClass(pClass);
	},
	
	toggleClassByElement: function(pElement, pClass) {
    jQuery(pElement).siblings('li').removeClass(pClass);
    jQuery(pElement).addClass(pClass);		
	}
}