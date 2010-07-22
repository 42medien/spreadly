/**
 * @nocombine platform
 */


/**
 * Pager, that works with data-attribute element
 * @author KM
 * @version 0.1
 */
var DataObjectPager = {
	
	/**
	 * set the data-attr with the given datastring(JSON-formatted) on the element by pId(CSS)
	 * @author KM
	 * @param string pId
	 * @param string pDataString(JSON)
	 */	
	init: function(pId, pDataString) {
    console.log("[DataObjectPager][init]");       		
		var lElement = jQuery('#'+pId);
		if(pDataString !== undefined){
		  jQuery(lElement).attr('data-obj', pDataString);
		}
		GlobalRequest.bindClickByElement(lElement);
	},
	
	/**
	 * updates a pager element by a given id and set the data-attr with new values
	 * @author KM
	 * @param string pId(CSS)
	 * @param string pAction
	 * @param string pPage
	 * @param object pDataObj
	 */
	update: function(pId, pAction, pPage, pDataObj) {
    console.log("[DataObjectPager][update]");
   	var lPage = parseInt(pPage);
   	lPage++;
   	pDataObj.page = String(lPage);
   	if(pAction && pAction !== undefined) {
   	  pDataObj.action = pAction;
   	}
    var lDataString = JSON.stringify(pDataObj);
    DataObjectPager.init(pId, lDataString);
	}
};