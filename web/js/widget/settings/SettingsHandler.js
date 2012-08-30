/**
 * @combine widget
 */

/**
 * Object to handle the behaviour of the settings layer by clicking the name in the popup
 * @author KM
 */
var ProfileSettings  = {
  
    /**
     * inits the settins menu
     * @author KM
     */
    init: function() {
      debug.log('[ProfileSettings][init]');       
      ProfileSettings.openMenu();
    },
    
    /**
     * opens the settings menu by clicking the name in the footer
     * @author KM
     */
    openMenu: function() {
      debug.log('[ProfileSettings][openMenu]');       
      jQuery('#edit-settings-link').live('click', function() {
        OnLoadGrafic.showGrafic(); 
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime()
        };
        
        jQuery.ajax({
          type : "GET",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            jQuery('#edit-settings').empty();
            jQuery('#edit-settings').append(pResponse.html);
            OnLoadGrafic.hideGrafic();
            ProfileSettings.closeMenu(); 
            ImageSettings.init();
          }
        });          
        jQuery('#edit-settings').slideDown('fast').fadeIn();
        
        return false;
      });
    },
    
    /**
     * close the menu by clicking the x on top-right in the menu
     * @author KM
     */
    closeMenu: function() {
      debug.log('[ProfileSettings][closeMenu]');
      jQuery('#close-settings-link').on('click', function() {
        jQuery('#edit-settings').slideUp('fast').fadeOut(); 
        jQuery('#edit-settings').empty();
        return false;
      });
      
    }
    
};


/**
 * handles the image selection in the settings menu (image settings = which image should be shown under the button after sharing)
 * @author KM
 */
var ImageSettings = {
    
    /**
     * inits the image settings functionalitys
     */
    init: function() {
      debug.log('[ImageSettings][selectImage]');      
      ImageSettings.selectImage();
    },
    
    /**
     * sets the clicked image as default image
     * @author KM
     */
    selectImage: function() {
      debug.log('[ImageSettings][selectImage]');
      jQuery('#select-img-list .select-profile-img-link').on('click', function(){
        OnLoadGrafic.showGrafic(); 
        var lThis = this;
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime(),
        };
        
        jQuery.ajax({
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            jQuery('.select-profile-img-link').removeClass('selected');
            jQuery(lThis).addClass('selected');
            OnLoadGrafic.hideGrafic();
          }
        }); 
        return false;
      });      
    }
};