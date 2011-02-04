var ShareDefaultSettings = {

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
          type : "GET",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            OnLoadGrafic.hideGrafic();
          }
        });        
    }
};