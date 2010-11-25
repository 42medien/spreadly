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
    
    DealForm.save();
    DealForm.selectDomainProfile();
  },
  
  save: function() {
    debug.log('[DealForm][save]');    
    var options = {
        url:       '/deals/save',
        data: { ei_kcuf: new Date().getTime() },
        type:      'POST',
        dataType:  'json',
        //resetForm: lReset,
        success:   function(pResponse) {
          debug.log('[DealForm][showProceed]');      
          Deal.showContent(pResponse.html);
          DealForm.init();          
        }
    };
   
    jQuery('#deal_form').submit(function() { 
      jQuery('#deal_form').ajaxSubmit(options);
      return false; 
    });
  },
  
  selectDomainProfile: function() {
    jQuery('#deal-domain-select-box #id').live('change', function() {
      var lDpId = jQuery(this).val();
      DealForm.changeDomainProfile(lDpId);
    });
  },
  
  changeDomainProfile: function(pDpId) {
    jQuery.ajax({
      type: "GET",
      url: '/deals/get_domain_profile',
      dataType: "json",
      data: {
        'dpid': pDpId,
        ei_kcuf: new Date().getTime()
        },        
      success: function (pResponse) {
        jQuery('#imprint_url').val(pResponse.imprint_url);
      }
    });  
  }
};

var Deal = {
    
  init: function() {
    Deal.bindClicks();
  },
  
  bindClicks: function() {
    jQuery('.link-deal-content').live('click', function() {
      var pDealId = (pDealId != undefined)? pDealId: '';
      var lAction = jQuery(this).attr('href');
      var lData = {
          ei_kcuf: new Date().getTime(),
          deal_id: pDealId
      };

      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        data: lData,        
        success: function (pResponse) {
          Deal.showContent(pResponse.html);
          DealForm.init();          
        }
      });
      return false;      
    });    
  },
    
  showContent: function(pHtml) {
    jQuery('#create-deal-content').empty();
    jQuery('#create-deal-content').append(pHtml);      
  }  
};