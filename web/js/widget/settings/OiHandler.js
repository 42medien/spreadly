/**
 * @combine widget
 * @returns
 */

var LikeIdentity = {

    init: function() {
      LikeIdentity.doDelete();
    },
    
    /**
     * sends the delete-request to settings/delete_oi and handles teh request
     */
    doDelete: function() {
      jQuery('.delete-oi-link').on('click', function() {
        OnLoadGrafic.showGrafic(); 
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime(),
        };
        
        jQuery.ajax({
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            jQuery('#like-submit').empty();
            jQuery('#like-submit').append(pResponse.html);
            
            var lTimeout;
            clearTimeout(lTimeout);
            lTimeout = setTimeout(function() {
              jQuery('#like-response').fadeOut('slow');
              jQuery('#like-response').empty();
            }, 3000);             
            LikeIdentity.init();
            OnLoadGrafic.hideGrafic();
          }
        });          
       
        return false;
      });
    }
    
};