var StreamItem = {
	
  aDetailAction: 'stream/get_item_detail',
  
  /**
   * set the action for the sub-filter-links global. The Action is defined in the last called action, e.g. new (response.action)
   * @author KM
   * @param string pAction

  setDetailAction: function(pAction) {
    console.log("[StreamItem][setAction]");    
    StreamItem.aDetailAction = pAction;
  },   */
  
  /**
   * returns the current action-string. is called in GlobalRequest. ATTENTION: this is used as callback-function in the GlobalRequest. 
   * If is not set, the following requests on click on a stream-item will not work
   * @author KM
   */
  getDetailAction: function() {
    console.log("[StreamItem][getAction]");    
    return StreamItem.aDetailAction;
  },
  
  updateCss: function(pCssObj) {
    var lCssObj = jQuery.parseJSON(pCssObj);
    ClassHandler.removeClassesByParent(jQuery('#new_shares'), 'item_active');    
    jQuery('#'+lCssObj["itemid"]).addClass('item_active');
  }
}