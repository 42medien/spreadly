/**
 * @combine platform
 */

/**
 * handles the behaviour of a single stream-item
 * @author karina
 */
var StreamItem = {
	
  aDetailAction: 'stream/get_item_detail',
  
  /**
   * returns the current action-string. is called in GlobalRequest. ATTENTION: this is used as callback-function in the GlobalRequest. 
   * If is not set, the following requests on click on a stream-item will not work
   * @author KM
   */
  getDetailAction: function() {
    console.log("[StreamItem][getAction]");    
    return StreamItem.aDetailAction;
  },
  
  /**
   * updates the css of the streamitem after clicking it
   * @author karina
   * @param object pCssObj(JSON)
   */
  updateCss: function(pCssObj) {
    console.log("[StreamItem][updateCss]");
    var lCssObj = jQuery.parseJSON(pCssObj);
    ClassHandler.removeClassesByParent(jQuery('#new_shares'), 'item_active');
    jQuery('#'+lCssObj["itemid"]).addClass('item_active');
  }
};