/**
 * @combine widget
 */

var ShareDefaultSettings = {
    
    resetForm: function() {
      // reset the form after side-reload (fix for ff)
      if (typeof (document.like_settings_form) != "undefined") {
        document.like_settings_form.reset();
      }  
    },
    
    updateSettings: function() {
      debug.log('[ShareDefaultSettings][addService]'); 
        jQuery('#update-settings-list .update-settings-cb').live('click', function() {
        OnLoadGrafic.showGrafic();      
        var lState = 'on', lOiId;
        lOiId = jQuery(this).attr('value');  
        
        if(jQuery(this).attr('checked') == false) {
          lState = 'off';
        }        
          
        var lAction = '/settings/update';
        var lData = {
          ei_kcuf : new Date().getTime(),
          state: lState,
          oiid: lOiId
        };
        
        jQuery.ajax({
          //beforeSubmit : OnLoadGrafic.showGrafic,
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            OnLoadGrafic.hideGrafic();
          }
        });  
      });        
    }    
};