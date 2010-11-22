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

    if (typeof(document.dealform) !=  "undefined"){
      document.dealform.reset();
    }

    jQuery('#deal_button_wording').toggleValue();
    jQuery('#deal_summary').toggleValue();
    jQuery('#deal_description').toggleValue();
    jQuery('#deal_button_wording').limit('35', '#button_wording_counter');
    jQuery('#deal_summary').limit('40', '#summary_counter');
    jQuery('#deal_description').limit('80', '#description_counter');

    DealForm.proceed();
  },

  proceed: function() {
    debug.log('[DealForm][proceed]');
    var options = {
        url:       '/deals/create',
        data: { ei_kcuf: new Date().getTime() },
        type:      'GET',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {DealForm.showGetButton(pResponse);}
    };
    jQuery('#deal_form').ajaxSubmit(options);
  },

  showGetButton: function(pReponse) {

  }

};

var DealCoupon = {
  init: function() {
    debug.log('[CreateDealCoupon][init]');
  }
};