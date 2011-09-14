/**
 * @combine widget
 */

var CouponCode = {
    
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