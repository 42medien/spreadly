/**
 * class to handle the verification process for the api
 * 
 * @nocombine statistics
 */

var ApiVerifier = {
    
  init: function() {
    debug.log('[ApiVerifier][init]');
    ApiVerifier.subscribe();
    ApiVerifier.unsubscribe();
  },
  
  subscribe: function() {
    debug.log('[ApiVerifier][subscribe]');    
    jQuery('#subscribe-api-button').live('click', function() {
      OnLoadGrafic.showGrafic();
      var options = {
        data : {
          ei_kcuf : new Date().getTime()
        },
        type : 'POST',
        dataType : 'json',
        success : function(pResponse) {
          jQuery('.form-response').hide();
          if(pResponse.success == true){
            jQuery('#verify-form-success').show('slow');
            jQuery('#unsubscribe-api').show('slow');
            jQuery('#subscribe-api-button').hide();
          } else {
            jQuery('#verify-form-error .error').empty();
            jQuery('#verify-form-error .error').text(pResponse.msg);
            jQuery('#verify-form-error').show('slow');            
          }
          
          //jQuery.fn.colorbox.resize({height:"350px"});

          OnLoadGrafic.hideGrafic();
        }
      };
      jQuery('#api-subscription-form').ajaxSubmit(options);
      return false;
    });
  },
  
  unsubscribe: function() {
    debug.log('[ApiVerifier][unsubscribe]');    
    jQuery('#unsubscribe-api-button').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      jQuery.ajax({
        type: "POST",
        url: lAction,
        dataType: "json",
        //data: options,        
        success: function (pResponse) {
          jQuery('.form-response').hide();
          if(pResponse.success == true){
            jQuery('#verify-form-error .error').empty();
            jQuery('#verify-form-error .error').append(pResponse.msg);
            jQuery('#verify-form-error').show('slow');
            jQuery('#unsubscribe-api-button').hide();
            jQuery('#subscribe-api-button').removeClass('hide');
            jQuery('#subscribe-api-button').show();
            jQuery('#endpoint-stats').hide();
            /*
            setTimeout(function() {
              jQuery.colorbox.close();
            }, 2000);    */                  
          }
          //jQuery.fn.colorbox.resize({height:"350px"});
          OnLoadGrafic.hideGrafic();
        }
      });        
      return false;
    });
  }
};