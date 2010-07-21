/**
 * @nocombine platform
 */

var DataObjectPager = {
	
	
	init: function(pId, pDataString) {
    console.log("[DataObjectPager][init]");       		
		var lElement = jQuery('#'+pId);
		jQuery(lElement).attr('data-obj', pDataString);
		GlobalRequest.bindClickByElement(lElement);
	},
	
	update: function(pId, pAction, pPage, pDataObj) {
    console.log("[DataObjectPager][update]");
   	var lPage = parseInt(pPage);
   	lPage++;
   	pDataObj.page = String(lPage);
   	pDataObj.action = pAction;
    var lDataString = JSON.stringify(pDataObj);
    DataObjectPager.init(pId, lDataString);
	}
};