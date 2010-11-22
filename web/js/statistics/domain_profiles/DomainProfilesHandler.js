/**
 * @combine statistics
 * class for DomainProfiles
 * @author KM
 */
 
var DomainProfilesHandler = {

  aClaimHtml: '',
  /**
   * inits the DomainProfiles functionalities
   * @author hannes
   */
  init: function() {
    DomainProfilesHandler.addNew();
    DomainProfilesHandler.getCode();
    DomainProfilesHandler.deleteDomain();
    DomainProfilesHandler.verifyDomain();
    DomainProfilesHandler.aClaimHtml = jQuery('#add-domain-profiles').html();
    DomainProfilesHandler.closeCode();
    jQuery('#domain_profile_url').toggleValue();    
    jQuery.fx.off = false;
  },
  
  addNew: function() {
    var lAddErrorTimeout = '', lAddDomainTimeout = '';
    jQuery('#new_domain_profile_form').ajaxForm({
      beforeSubmit: OnLoadGrafic.showGrafic,
      success: function(pResponse) {
        if(pResponse.success == true) {
          if(jQuery('table#domain_profiles_table tbody tr:first').attr('id') == 'no-claim') {
            jQuery('table#domain_profiles_table tbody tr:first').remove();
          }
          jQuery('#domain_profiles_table tbody').prepend(pResponse.domain_profiles_table);
          var lCssId = jQuery(pResponse.domain_profiles_table).attr('id');
          jQuery('#'+lCssId).fadeIn('slow');
          DomainProfilesHandler.showCode('/domain_profiles/get_verify_code?host_id='+pResponse.host_id);
        } else if(pResponse.success == false) {
          jQuery('#add-url-error').empty();
          jQuery('#add-url-error').append(pResponse.formerror);
          jQuery('#add-url-error').show('slow');
          clearTimeout(lAddErrorTimeout);
          lAddErrorTimeout = setTimeout(function() {
            jQuery('#add-url-error').hide('slow');
            jQuery('#add-url-error').empty();
          }, 5000);          
        }
        OnLoadGrafic.hideGrafic();
      }
    });    
  },
  
  getCode: function() {
    jQuery('.get-verify-code').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      DomainProfilesHandler.showCode(lAction);
      return false;
    });
  },
  
  showCode: function(pAction) {
    debug.log('[DomainProfilesHandler][showCode]');
    jQuery.ajax({
      type: "GET",
      url: pAction,
      dataType: "json",
      data: { ei_kcuf: new Date().getTime() },        
      success: function (pResponse) {
        jQuery('#add-domain-profiles').empty();
        jQuery('#add-domain-profiles').append(pResponse.code); 
        DomainProfilesHandler.closeCode(); 
        OnLoadGrafic.hideGrafic();
      }
    });       
  },
  
  closeCode: function() {
    jQuery('#close-verify-code').live('click', function() {
      jQuery('#add-domain-profiles').empty();
      jQuery('#add-domain-profiles').append(DomainProfilesHandler.aClaimHtml);  
      DomainProfilesHandler.addNew();      
      return false;
    });
  },
  
  deleteDomain: function() {
    jQuery('.delete-verify-code').live('click', function() {
      var lConfirm = confirm(i18n.get('DELETE_DOMAIN'));
      OnLoadGrafic.showGrafic();
      if(lConfirm == true) {
        var lAction = jQuery(this).attr('href');
        jQuery.ajax({
          type: "GET",
          url: lAction,
          dataType: "json",
          data: { ei_kcuf: new Date().getTime() },          
          success: function (pResponse) {
            if(pResponse.success === true) {
              jQuery('#domain-profile-row-'+pResponse.host_id).hide('slow');
              jQuery('#domain-profile-row-'+pResponse.host_id).remove();
              OnLoadGrafic.hideGrafic();
            }
          }
        });  
      } else {
        OnLoadGrafic.hideGrafic();        
      }
      return false;
    });    
  },
  
  verifyDomain: function() {
    jQuery('.verify-verify-code').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        data: { ei_kcuf: new Date().getTime() },        
        success: function (pResponse) {
          jQuery('#domain-profile-row-'+pResponse.host_id).empty();
          jQuery('#domain-profile-row-'+pResponse.host_id).append(pResponse.row);
          OnLoadGrafic.hideGrafic();
        }
      });   
      return false;
    });      
  }
}
