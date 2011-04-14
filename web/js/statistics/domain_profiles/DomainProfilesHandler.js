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
    debug.log('[DomainProfilesHandler][init]');
    DomainProfilesHandler.addNew();
    DomainProfilesHandler.getCode();
    DomainProfilesHandler.deleteDomain();
    DomainProfilesHandler.verifyDomain();
    DomainProfilesHandler.aClaimHtml = jQuery('#add-domain-profiles').html();
    DomainProfilesHandler.closeCode();
    jQuery('#domain_profile_url').toggleValue();    
    jQuery.fx.off = false;
  },
  
  /**
   * adds a new domain-profile
   * @author KM
   */
  addNew: function() {
    debug.log('[DomainProfilesHandler][addNew]');    
    var lAddErrorTimeout = '', lAddDomainTimeout = '', lCssId='';
    
    jQuery('#new_domain_profile_form').ajaxForm({
      beforeSubmit: OnLoadGrafic.showGrafic,
      success: function(pResponse) {
        //if the domain-profile is successfully created
        if(pResponse.success == true) {
          if(jQuery('#domain_profiles_table table tbody tr:first').attr('id') == 'no-claim') {
            jQuery('#domain_profiles_table table tbody tr:first').remove();
          }
          jQuery('#domain_profiles_table tbody').prepend(pResponse.domain_profiles_table);
          lCssId = jQuery(pResponse.domain_profiles_table).attr('id');
          jQuery('#'+lCssId).fadeIn('slow');
          DomainProfilesHandler.showCode('/domain_profiles/get_verify_code?host_id='+pResponse.host_id);
        } else if(pResponse.success == false) {
          //if there is thrown an error on creating an domain-profile
          jQuery('#add-url-error').empty();
          jQuery('#add-url-error').append(pResponse.formerror);
          jQuery('#add-url-error').show('slow');
          //hides errors after 5 seconds
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
  
  /**
   * binds click to show the microid-code
   * @author KM
   */
  getCode: function() {
    debug.log('[DomainProfilesHandler][getCode]');       
    jQuery('.get-verify-code').live('click', function() {
      OnLoadGrafic.showGrafic();
      var lAction = jQuery(this).attr('href');
      DomainProfilesHandler.showCode(lAction);
      return false;
    });
  },
  
  /**
   * shows the code after a request to the action given in pAction-param
   * @author KM
   * @param pAction
   */
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
  
  /**
   * close the show code box and shows the add-profile-form
   * @author KM
   */
  closeCode: function() {
    debug.log('[DomainProfilesHandler][closeCode]');    
    jQuery('#close-verify-code').live('click', function() {
      jQuery('#add-domain-profiles').empty();
      jQuery('#add-domain-profiles').append(DomainProfilesHandler.aClaimHtml);  
      jQuery("select.custom-select").jgdDropdown();      
      DomainProfilesHandler.addNew();      
      return false;
    });
  },
  
  /**
   * 
   */
  deleteDomain: function() {
    debug.log('[DomainProfilesHandler][deleteDomain]');      
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
};
