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
   */
  init : function() {
    debug.log('[Deal][init]');
    Deal.bindClicks();
  },
  
  /**
   * bind the clicks to refresh the content with response-html
   * 
   * @author KM
   */
  bindClicks : function() {
    debug.log('[Deal][bindClicks]');
    jQuery('.link-deal-content').live('click', function() {
      var lAction = jQuery(this).attr('href');
      var lData = {
        ei_kcuf : new Date().getTime()
      };
      
      jQuery.ajax({
        beforeSubmit : OnLoadGrafic.showGrafic,
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
  },
  
  showStats: function(){
    jQuery('.deal-stats-link').live('click', function() {
      var lAction = jQuery(this).attr('href');
      var lData = {
        ei_kcuf : new Date().getTime()
      };
      
      jQuery.ajax({
        beforeSubmit : OnLoadGrafic.showGrafic,
        type : "GET",
        url : lAction,
        dataType : "json",
        data : lData,
        success : function(pResponse) {
          jQuery('#analytix-filter-nav-box, #analytix-content-box').show();
          AnalyticsFilterNav.show(pResponse.nav);
          AnalyticsFilterContent.show(pResponse.content);
          OnLoadGrafic.hideGrafic();
        }
      });
      return false;      
    });
  }
};

/**
 * form-functionalities
 * 
 * @author KM
 */
var DealForm = {
  
  /**
   * inits the effects for the form
   * 
   * @author KM
   */
  init : function() {
    debug.log('[CreateDealForm][init]');
    
    // inits the form-save
    DealForm.save();
    
    // inits the filling of the fields after selecting a domain-profile
    DealForm.selectDomainProfile();
    DealForm.toggleCouponType();
    DealForm.toggleTagBoxes();    
    DealForm.setRadioButtons();
    DealForm.countCodes();    
    
    // init datetime-picker for start and enddate
    jQuery('input#deal_start_date').datetime({
      userLang : 'de'
    });
    jQuery('input#deal_end_date').datetime({
      userLang : 'de'
    });
    
    // reset the form after side-reload (fix for ff)
    if (typeof (document.deal_form) != "undefined") {
      document.deal_form.reset();
    }
    
    // empty the text-values after clicking in it
    jQuery('#deal_button_wording').toggleValue();
    jQuery('#deal_summary').toggleValue();
    jQuery('#deal_description').toggleValue();
    jQuery('#deal_terms_of_deal').toggleValue();    
    jQuery('#deal_redeem_url').toggleValue();

    jQuery('.mirror-value').mirrorValue();    
    // limits the text-values
    jQuery('#deal_button_wording').limitValue('35', '#button_wording_counter');
    jQuery('#deal_summary').limitValue(40, '#summary_counter');
    jQuery('#deal_description').limitValue(80, '#description_counter');
  },
  
  /**
   * form save for new-deal-form
   * 
   * @author KM
   */
  save: function() {
    debug.log('[DealForm][save]');
    
    jQuery('#proceed-deal-button').bind('click', function() {
      var options = {
        //beforeSubmit : OnLoadGrafic.showGrafic,
        url : '/deals/save',
        data : {
          ei_kcuf : new Date().getTime()
        },
        type : 'POST',
        dataType : 'json',
        // resetForm: lReset,
        success : function(pResponse) {
          debug.log('response');
          Deal.showContent(pResponse.html);
          DealTable.update();
          DealForm.init();
          OnLoadGrafic.hideGrafic();
        }
      };
      
       jQuery('#deal_form').ajaxSubmit(options);
       return false;
    });
  },
  
  /**
   * change the form after selecting a domain-profile
   * 
   * @author KM
   */
  selectDomainProfile : function() {
    debug.log('[DealForm][selectDomainProfile]');
    jQuery('#deal-domain-select-box #id').change(function() {
      var lDpId = jQuery(this).val();
      DealForm.changeDomainProfile(lDpId);
    });
  },
  
  /**
   * send request to get the data and changes the form-fields of the selected
   * domain-profile
   * 
   * @author KM
   * @param int
   *          pDpId
   */
  changeDomainProfile : function(pDpId) {
    debug.log('[DealForm][changeDomainProfile]');
    jQuery.ajax({
      beforeSubmit : OnLoadGrafic.showGrafic,
      type : "GET",
      url : '/deals/get_form_by_domain',
      dataType : "json",
      data : {
        'dpid' : pDpId,
        ei_kcuf : new Date().getTime()
      },
      success : function(pResponse) {
        Deal.showContent(pResponse.html);
        DealForm.init();
        OnLoadGrafic.hideGrafic();
      }
    });
  },
  
  /**
   * toggles the code-form-fields after select a coupon-type
   * 
   * @author KM
   */
  toggleCouponType : function() {
    debug.log('[DealForm][toggleCouponType]');
    jQuery('ul.radio_list li.coupon-type-select input:radio').live('click',
        function() {
          var lId = jQuery(this).attr('id');
          if (lId == 'deal_coupon_type_single') {
            jQuery('#multiple-code-row').hide();
            jQuery('#single-code-row').show();
          } else {
            jQuery('#single-code-row').hide();
            jQuery('#multiple-code-row').show();
          }
        });
  },
  
  /**
   * toggles the categories after choosing insert categories
   * 
   * @author KM
   */
  toggleTagBoxes : function() {
    debug.log('[DealForm][toggleTagBoxes]');
    jQuery('ul.radio_list li.tags-select input:radio').live('click',
        function() {
          var lId = jQuery(this).attr('id');
          if (lId == 'deal_addtags_addnotags') {
            jQuery('#deal_tag_row').hide();
          } else {
            jQuery('#deal_tag_row').show();
          }
        });
  },  
  
  /**
   * set the radiobuttons if user click on the label-field
   * 
   * @author KM
   */
  setRadioButtons : function() {
    debug.log('[DealForm][setRadioButtons]');
    jQuery('#edit-quantity').bind('click', function() {
      jQuery('#radio-single-quantity').attr('checked', true);
      return true;
    });
    
    jQuery('#single-quantity-unlimited').bind('click', function() {
      jQuery('#radio-single-quantity-unltd').attr('checked', true);
      return true;
    });
  },
  
  /**
   * update the count of pasted codes
   * 
   * @author KM
   */
  countCodes : function() {
    debug.log('[DealForm][countCodes]');
    var lString, lCount, lNewCount;
    lCount = parseInt(jQuery('#code-counter').text(), 10);
    jQuery('#deal_coupon_multiple_codes').keyup(function() {
      lString = jQuery(this).val();
      lNewCount = Utils.getCountByCommaNl(lString);
      jQuery('#code-counter').empty();
      jQuery('#code-counter').text(parseInt(lNewCount, 10) + parseInt(lCount, 10));
    });
  }
};

var DealTable = {
  
  init : function() {
    debug.log("[DealTable][init]");
    EditInPlace.init('click');
    DealTable.updateRow();
  },
  
  /**
   * inits the datepicker on edit-date-field
   * 
   * @author KM
   */
  editDate : function() {
    debug.log("[DealTable][editDate]");
    jQuery('input#editinplace_input').datetime({
      userLang : 'de'
    });
  },
  
  /**
   * saves the new codes in the layer
   * 
   * @author KM
   */
  saveCodes : function() {
    debug.log('[DealTable][saveCodes]');
    var options = {
      url : '/deals/save_codes',
      data : {
        ei_kcuf : new Date().getTime()
      },
      type : 'POST',
      dataType : 'json',
      // resetForm: lReset,
      success : function(pResponse) {
        EditInPlace.update(pResponse.cssid, pResponse.html);
        jQuery(document).trigger('close.facebox');
      }
    };
    
    jQuery('#save_codes_form').submit(function() {
      debug.log('fdsfsa');
      jQuery('#save_codes_form').ajaxSubmit(options);
      return false;
    });
  },
  
  /**
   * close the layer if user click cancel
   * 
   * @author KM
   */
  cancelLayer : function() {
    jQuery('#cancel_layer').bind('click', function() {
      jQuery(document).trigger('close.facebox');
      return false;
    });
  },
  
  /**
   * set the new states after clicking an action-icon
   * 
   * @author KM
   */
  updateRow : function() {
    debug.log('[DealTable][udateRow]');
    jQuery('.edit-state').live('click', function() {
      var lAction = jQuery(this).attr('href');
      var lCssId = jQuery(this).parent('td').parent('tr').attr('id');
      jQuery.ajax({
        type : "GET",
        url : lAction,
        dataType : "json",
        success : function(pResponse) {
          if (pResponse.success === true) {
            DealTable.showRow(lCssId, pResponse.html, pResponse.state, pResponse.classes);
            DealTable.init();
          } else {
            // alert if there are validation-errors
            alert(pResponse.error);
          }
        }
      });
      return false;
    });
  },
  
  /**
   * show a new edited row
   * 
   * @author KM
   */
  showRow : function(pCssId, pRow, pState, pClasses) {
    debug.log('[DealTable][showRow]');
    var lId = '#' + pCssId;
    jQuery(lId).empty();
    jQuery(lId).removeClass(pState);
    jQuery(lId).removeClass('deal_active');
    jQuery(lId).removeClass('deal_inactive');
    jQuery(lId).addClass(pClasses);
    jQuery(lId).append(pRow);
  },
  
  /**
   * updates the hole table
   * 
   * @author KM
   */
  update : function() {
    debug.log('[DealTable][update]');
    jQuery.ajax({
      type : "GET",
      url : '/deals/get_deal_table',
      dataType : "json",
      success : function(pResponse) {
        if (pResponse.success === true) {
          jQuery('#deal-table-box').empty();
          jQuery('#deal-table-box').append(pResponse.html);
          DealTable.init();
        }
      }
    });
  }
};