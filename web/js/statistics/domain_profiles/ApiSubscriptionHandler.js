/**
 * class to handle the verification process for the api
 * 
 * @nocombine statistics
 */

var ApiVerifier = {
    
  aStatus: '',
    
  /**
   * inits the Api-Verify-functionality
   * @author KM
   */
  init: function() {
    debug.log('[ApiVerifier][init]');
    ApiVerifier.subscribe();
    ApiVerifier.unsubscribe();
  },
  
  
  /**
   * sends the request, if the user click verifiy
   * @author KM
   */
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
            ApiVerifier.aStatus = 'subscribed';
          } else {
            ApiVerifier.aStatus = 'error';         
          }
          ApiVerifier.toggleView(pResponse);          
          //jQuery.fn.colorbox.resize({height:"350px"});
          OnLoadGrafic.hideGrafic();
        }
      };
      jQuery('#api-subscription-form').ajaxSubmit(options);
      return false;
    });
  },
  
  /**
   * sends the request, if the user click unsubscribe
   * @author KM
   */  
  unsubscribe: function() {
    debug.log('[ApiVerifier][unsubscribe]');    
    jQuery('#unsubscribe-api-button').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      jQuery.ajax({
        type: "POST",
        url: lAction,
        dataType: "json",
        data : {
          ei_kcuf : new Date().getTime()
        },       
        success: function (pResponse) {
          jQuery('.form-response').hide();
          if(pResponse.success == true){
            ApiVerifier.aStatus = 'unsubscribed';         
          } else {
            ApiVerifier.aStatus = 'error';         
          }
          ApiVerifier.toggleView(pResponse);               
          OnLoadGrafic.hideGrafic();
        }
      });        
      return false;
    });
  },
  
  /**
   * "factory method" to toggle the view if user clicked un/subscribe or if there is thrown an error
   * @param object pResponse
   */
  toggleView: function(pResponse) {
    debug.log('[ApiVerifier][toggleView]');
    if(ApiVerifier.aStatus == 'subscribed') {
      debug.log('subscribed');
      jQuery('#verify-form-success').show('slow');
      jQuery('#unsubscribe-api').show('slow');
      jQuery('#subscribe-api-button').hide();
      jQuery('#unsubscribe-api-button').show();
      DomainProfilesHandler.updateRow(pResponse);           
    } else if(ApiVerifier.aStatus == 'unsubscribed') {
      debug.log('unsubscribed'); 
      ApiVerifier.showError(pResponse.msg);
      jQuery('#unsubscribe-api-button').hide();
      jQuery('#subscribe-api-button').removeClass('hide');
      jQuery('#subscribe-api-button').show();
      jQuery('#endpoint-stats').hide();
      DomainProfilesHandler.updateRow(pResponse);            
      setTimeout(function() {
        jQuery.colorbox.close();
      }, 2000);          
    } else if(ApiVerifier.aStatus == 'error') {
      debug.log('error');         
      ApiVerifier.showError(pResponse.msg);      
    }
    OnLoadGrafic.hideGrafic();    
  },
  
  showError: function(pMsg) {
    debug.log('[ApiVerifier][showError]');    
    jQuery('#verify-form-error .error').empty();
    jQuery('#verify-form-error .error').append(pMsg);
    jQuery('#verify-form-error').show('slow');    
  }
};