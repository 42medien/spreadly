/**
 * @nocombine statistics
 */

/**
 * form-functionalities
 * @author KM
 */
var DealForm = {
  
  /**
   * inits the effects for the form
   * @author KM
   */
  init: function() {
    debug.log('[CreateDealForm][init]');
    
    //init datetime-picker for start and enddate
    var lStartDate = jQuery('input#deal_start_date').datetime({userLang  : 'de'});
    jQuery('input#deal_end_date').datetime({userLang  : 'de'}); 
    
    //reset the form after side-reload (fix for ff)    
    if (typeof(document.deal_form) !=  "undefined"){ document.deal_form.reset(); }
    
    //empty the text-values after clicking in it
    jQuery('#deal_button_wording').toggleValue();
    jQuery('#deal_summary').toggleValue();
    jQuery('#deal_description').toggleValue();  
    
    //limits the text-values
    jQuery('#deal_button_wording').limit('35', '#button_wording_counter');
    jQuery('#deal_summary').limit('40', '#summary_counter');
    jQuery('#deal_description').limit('80', '#description_counter');
    
    //inits the form-save
    DealForm.save();
    
    //inits the filling of the fields after selecting a domain-profile
    DealForm.selectDomainProfile();
  },
  
  /**
   * form save for new-deal-form
   * @author KM
   */
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
  
  /**
   * change the form after selecting a domain-profile
   * @author KM 
   */
  selectDomainProfile: function() {
    jQuery('#deal-domain-select-box #id').live('change', function() {
      var lDpId = jQuery(this).val();
      DealForm.changeDomainProfile(lDpId);
    });
  },
  
  /**
   * send request to get the data and changes the form-fields of the selected domain-profile
   * 
   * @author KM
   * @param int pDpId
   */
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

/**
 * Class to handle the effects for the deal
 * @author KM
 */
var Deal = {
    
  /**
   * inits the deal-effects
   */
  init: function() {
    Deal.bindClicks();
  },
  
  /**
   * bind the clicks to refresh the content with response-html
   * @author KM
   */
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
          if(pResponse.initform != undefined && pResponse.initform == true) {
            DealForm.init();
          }
        }
      });
      return false;      
    });    
  },
    
  /**
   * shows the content
   * @author KM
   * @param pHtml
   */
  showContent: function(pHtml) {
    jQuery('#create-deal-content').empty();
    jQuery('#create-deal-content').append(pHtml);      
  }  
};

var DealTable = {
    
  editDate: function(){
    debug.log("[DealTable][editDate]");
    jQuery('input#editinplace-input').datetime({userLang  : 'de'});     
  }
};