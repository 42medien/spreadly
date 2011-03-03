/**
 * @nocombine statistics
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
      Deal.hideStats();      
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
  },
  
  hideStats: function() {
    jQuery('#analytix-filter-nav-box, #analytix-content-box').hide();    
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
    jQuery('#deal_start_date').datetimepicker({
      showSecond: true,
      timeFormat: 'hh:mm:ss',
      dateFormat: 'yy-mm-dd'      
    });
    
    jQuery('#deal_end_date').datetimepicker({
      showSecond: true,
      timeFormat: 'hh:mm:ss',
      dateFormat: 'yy-mm-dd'            
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
   * binds the autocomplete to the categories field and inits the plugin
   * @deprecated Wird vorerst rausgenommen, da tag-vorschlagsliste problematisch im Backend
   */
  initAutocomplete: function() {
    debug.log('[CreateDealForm][initAutocomplete]'); 
    jQuery( "#deal_tags" ).bind( "keydown", function( event ) {
      if ( event.keyCode === $.ui.keyCode.TAB &&
          $( this ).data( "autocomplete" ).menu.active ) {
        event.preventDefault();
      }
      debug.log('keydown');
    })
    .autocomplete({
      source: function( request, response ) {
        jQuery.getJSON( "/deals/get_tags", {
          term: extractLast( request.term ),
          value: encodeURI(jQuery('#deal_tags').val())
        }, response );
      },
      search: function() {
        // custom minLength
        var term = extractLast( this.value );
        if ( term.length < 2 ) {
          return false;
        }
      },
      focus: function() {
        // prevent value inserted on focus
        return false;
      },
      select: function( event, ui ) {
        var terms = split( this.value );
        // remove the current input
        terms.pop();
        // add the selected item
        terms.push( ui.item.value );
        // add placeholder to get the comma-and-space at the end
        terms.push( "" );
        this.value = terms.join( ", " );
        return false;
      }
    }); 
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
          //jQuery("input[type='checkbox']").custCheckBox();
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
   * @depricated wird jetzt in deal.init innerhalb der callback vom dropdown ausgeführt
   */
  selectDomainProfile : function() {
    debug.log('[DealForm][selectDomainProfile]');
    jQuery('#websellist #id').change(function() {
      debug.log(this);
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
          debug.log(lId);
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
            //DealForm.initAutocomplete();
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

function split( val ) {
  return val.split( /,\s*/ );
}
function extractLast( term ) {
  return split( term ).pop();
}