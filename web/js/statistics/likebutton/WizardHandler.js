/**
 * @nocombine statistics
 */
var ConfigWizard = {
    
  aCulture: "",  
  aClipFlashPath: "",
  
  /**
   * inits the wizard functionality
   * @author KM
   */
  init: function(pCulture, pClipFlashPath) {
    debug.log("[ConfigWizard][init]");        
    WizardNavigation.chooseTypeOfSite();
    ConfigWizard.aCulture = pCulture;
    ConfigWizard.aClipFlashPath = pClipFlashPath;
    ConfigWizard.chooseApp();
    StaticConfig.unbind();
    DynamicConfig.unbind();
    
    //WizardNavigation.chooseAnyWebsite();
    //WizardNavigation.chooseTypeOfSite();
    //WizardNavigation.chooseEmailSignatures();  
  },
  
  /**
   * displays the dynamic or static conigurator
   * @author KM, CS
   */
  chooseApp: function() {
    debug.log("[ConfigWizard][chooseApp]");      
    jQuery('.config-app-link').live('click', function() {
      var lAction = jQuery(this).attr('href');
      jQuery.ajax({
        type: "GET",
        url: lAction,
        dataType: "json",
        success: function (response) {
          jQuery('#main_area_content').empty();
          jQuery('#nav_choose_app').removeClass('active');
          jQuery('#nav_choose_style').removeClass('hide');
          jQuery('#nav_choose_style').addClass('show');
          jQuery('#main_area_content').html(response.html);
          if(response.type == 'dynamic') {
            DynamicConfig.init();
          } else {
            StaticConfig.init();
          }
        }
      });
      return false;
    });    
  }
};


/**
 * class to handle the top-navigation of the wizard
 */
var WizardNavigation = {
    
  /**
   * navigates back to the first subpage "Choose Type of Site"
   * @author Christian Schätzle
   */
  chooseTypeOfSite: function() {
    debug.log("[WizardNavigation][chooseTypeOfSite]");    
    jQuery('#nav_element_choose_app').live('click', function() {
      StaticConfig.unbind();
      DynamicConfig.unbind();        
      jQuery.ajax({
        type: "GET",
        url: '/likebutton/get_choose_app',
        dataType: "json",
        success: function (response) {
          jQuery('#main_area_content').empty();
          jQuery('#nav_choose_app').addClass('active');
          jQuery('#nav_choose_style').addClass('hide');
          jQuery('#nav_choose_style').removeClass('show');
          jQuery('#main_area_content').html(response.html);
        }
      });
      
      return false;
    });
    
    jQuery('#nav_element_choose_style').live('click', function() {
      return false;
    });
  }
};