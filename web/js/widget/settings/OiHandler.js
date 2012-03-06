/**
 * @nocombine widget
 * @returns
 */

var LikeIdentity = {
    init: function() {
      LikeIdentity.doDelete();
      
    },
    
    doDelete: function() {
      jQuery('.delete-oi-link').live('click', function() {
        OnLoadGrafic.showGrafic(); 
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime(),
        };
        
        
        jQuery.ajax({
          //beforeSubmit : OnLoadGrafic.showGrafic,
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            console.log(pResponse.success);
            if(pResponse.success == true) {
              jQuery('#like-submit').empty();
              jQuery('#like-submit').append(pResponse.html);
            }
            
            OnLoadGrafic.hideGrafic();
          }
        });          
       
        return false;
      });
    }
    
};