/**
 * @nocombine platform
 */

var TextHandler = {
  toggleById: function(pId, pCurrent, pNew) {
    var lElement = jQuery('#'+pId);
    lCurrent = jQuery('#'+pId).text();
    
    if(lCurrent == pCurrent){
      jQuery(lElement).text(pNew);
    } else if(lCurrent == pNew) {
      jQuery(lElement).text(pCurrent);      
    }
  }
};