/**
 * @nocombine statistics
 */

/**
 * form-functionalities
 * @author KM
 */
var DealForm = {
  init: function() {
    debug.log('[CreateDealForm][init]');
    var lStartDate = jQuery('input#deal_start_date').datetime({userLang  : 'de'});
    jQuery('input#deal_end_date').datetime({userLang  : 'de'}); 
    
    if (typeof(document.deal_form) !=  "undefined"){
      document.deal_form.reset();
    }
    
    if (typeof(document.save_deal_form) !=  "undefined"){
      document.save_deal_form.reset();
    }    
    
    jQuery('#deal_button_wording').toggleValue();
    jQuery('#deal_summary').toggleValue();
    jQuery('#deal_description').toggleValue();    
    jQuery('#deal_button_wording').limit('35', '#button_wording_counter');
    jQuery('#deal_summary').limit('40', '#summary_counter');
    jQuery('#deal_description').limit('80', '#description_counter');
    
    DealForm.proceed();
    DealForm.toggleCodeBox();
    DealForm.save();
  },
  
  proceed: function() {
    debug.log('[DealForm][proceed]');    
    var options = {
        url:       '/deals/proceed',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {DealForm.showProceed(pResponse);}
    };
   
    jQuery('#deal_form').submit(function() { 
      jQuery('#deal_form').ajaxSubmit(options);
      return false; 
    });
    
  },
  
  showProceed: function(pResponse) {
    debug.log('[DealForm][showProceed]');      
    jQuery('#create-deal-content').empty();
    jQuery('#create-deal-content').append(pResponse.html);  
    DealForm.init();
  },
  
  toggleCodeBox: function() {
    jQuery('#radio-no-code').live('change', function() {
      jQuery('#no-code-box').show('slow');
    });
    
    jQuery('#radio-has-code').live('change', function() {
      jQuery('#no-code-box').hide('slow');
    });    
  },
  
  save: function() {
    debug.log('[DealForm][save]');    
    var options = {
        url:       '/deals/save',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {DealForm.showSave(pResponse);}
    };
   
    jQuery('#save_deal_form').submit(function() { 
      jQuery('#save_deal_form').ajaxSubmit(options);
      return false; 
    });    
  },
  
  showSave: function(pResponse) {
    debug.log('[DealForm][showSave]');      
    jQuery('#create-deal-content').empty();
    jQuery('#create-deal-content').append(pResponse.html);
    if(pResponse.getdealcode && pResponse.getdealcode=='true') {
      jQuery('#radio-no-code').attr("checked","checked");
      jQuery('#radio-has-code').attr("checked",false); 
      jQuery('#no-code-box').show();
    } else {
      jQuery('#radio-no-code').attr("checked", false);
      jQuery('#radio-has-code').attr("checked", "checked");       
    }
    DealForm.save();
  }
  
};

var DealCoupon = {
  init: function() {
    debug.log('[CreateDealCoupon][init]');  
  }
};