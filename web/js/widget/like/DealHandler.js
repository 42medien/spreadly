/**
 * @combine widget
 */

var CouponCode = {
    
    /**
     * var to save the path for the copy to clipboard-swf
     */
    //aClipFlashPath: "",    
      
    /**
     * inits the copy to clipboard functionality
     * @author KM
     */
    initClipboard: function(pPath) {
      debug.log("[CouponCode][initClipboard]");   
      jQuery('a#copy-code-button').zclip({
        path: pPath,
        copy: jQuery('span#redeemcode').text()
      });

    }
    
};