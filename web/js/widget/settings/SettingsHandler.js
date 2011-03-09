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

    toggleService: function() {
      debug.log('[ShareDefaultSettings][addService]'); 
      OnLoadGrafic.showGrafic();
        var lState = 'on', lOiId;
        lOiId = jQuery(this).siblings('.checkbox').attr('value');
        
        if(jQuery(this).hasClass('cust_checkbox_off')) {
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
    }
};