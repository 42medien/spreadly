/**
 * @combine statistics
 */

/**
 * Class to handle the effects for the deal
 * 
 * @author KM
 */
var Deal = {
  
  /**
   * inits the deal-effects
   * @deprecated not in use anymore
   */
  init : function() {
    debug.log('[Deal][init]');
    Deal.bindClicks();
    Deal.initDropdown();
  },
  
  /**
   * inits the bg-dropdown-magic
   */
  initDropdown: function() {
    jQuery("select.custom-select").jgdDropdown({callback: function(obj, val) {
      DealForm.changeDomainProfile(val);
    }});    
  },
  
  /**
   * bind the clicks to refresh the content with response-html
   * 
   * @author KM
   */
  bindClicks : function() {
    debug.log('[Deal][bindClicks]');
    jQuery('.link-deal-content').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      var lData = {
        ei_kcuf : new Date().getTime()
      };
      
      jQuery.ajax({
        //beforeSubmit : OnLoadGrafic.showGrafic,
        type : "GET",
        url : lAction,
        dataType : "json",
        data : lData,
        success : function(pResponse) {
          Deal.showContent(pResponse.html);
          if (pResponse.initform !== undefined && pResponse.initform === true) {
            DealForm.init();
          }
          OnLoadGrafic.hideGrafic();
        }
      });
      //Deal.hideStats();      
      return false;
    });
  },
  
  /**
   * shows the contents
   * 
   * @author KM
   * @param pHtml
   */
  showContent : function(pHtml) {
    debug.log('[Deal][showContent]');
    jQuery('#create-deal-content').empty();
    jQuery('#create-deal-content').append(pHtml);
    Deal.initDropdown();    
    jQuery("input[type='checkbox']").custCheckBox();
  }
};

/**
 * create new deal form
 * 
 * @author KM
 */
var DealForm = {

    init: function() {
      debug.log('[DealForm][init]');
      
      // reset the form after side-reload (fix for ff)
      if (typeof (document.deal_form) != "undefined") {
        document.deal_form.reset();
      }      
      
      DealForm.initCharCounter();
      DealForm.toggleCouponType();
      DealForm.toggleCampaignType();
    },
    
    initCharCounter: function() {
      debug.log('[DealForm][initCharCounter]');      
      jQuery('#motivation_title').limitValue('255', '#motivation_title_counter');
      jQuery('#motivation_text').limitValue('500', '#motivation_text_counter'); 
      jQuery('#spread_title').limitValue('255', '#spread_title_counter');   
      jQuery('#spread_text').limitValue('500', '#spread_text_counter');
      jQuery('#coupon_title').limitValue('255', '#coupon_title_counter');
      jQuery('#coupon_text').limitValue('500', '#coupon_text_counter');
      jQuery('#coupon_code').limitValue('255', '#coupon_code_counter');      
      
    },
    
    toggleCouponType: function() {
      debug.log('[DealForm][toggleCouponType]');         
      jQuery('li.coupon-type-select ul.radio_list input:radio').live('click', function() {
            var lId = jQuery(this).attr('id');
            if (lId == 'coupon_type_download' || lId == 'coupon_type_url') {
              jQuery('#coupon-code-row').hide();
              jQuery('#coupon-redeem-row').hide();
              jQuery('#coupon-webhook-row').hide();                
              jQuery('#coupon-url-row').show();
            } else if(lId == 'coupon_type_unique_code') { 
              jQuery('#coupon-code-row').hide();            
              jQuery('#coupon-url-row').hide();              
              jQuery('#coupon-redeem-row').show();              
              jQuery('#coupon-webhook-row').show();              
            } else {
              jQuery('#coupon-url-row').hide();
              jQuery('#coupon-webhook-row').hide();                 
              jQuery('#coupon-code-row').show();
              jQuery('#coupon-redeem-row').show();
            }
            
            jQuery('#coupon-preview-img').attr('src', '/img/'+lId+".png");
            
            return true;
     });      
    },
    
    
    /**
     * toggles the hidden field billing_type on step_campaing
     * @author KM
     */
    toggleCampaignType: function() {
      debug.log('[DealForm][toggleCampaignType]');         
      jQuery('li.select-target-quantity ul.radio_list li').live('click', function() {
        var lType;
        lType = jQuery(this).parent('ul').parent('span').parent('li.select-target-quantity').attr('id');
        if(lType == 'select-target-quantity'){
          jQuery('#billing_type').val('like');
          jQuery('.target_quantity_mp').attr('checked', false);
        } else {
          jQuery('#billing_type').val('media_penetration');
          jQuery('.target_quantity_like').attr('checked', false);          
        }      
      });
    }
};


