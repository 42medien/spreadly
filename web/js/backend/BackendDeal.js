/**
 * @nocombine backend
 */

var BackendDeal = {
    
    init: function() {
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
      
      jQuery('#deal_button_wording').limitValue('110', '#button_wording_counter');
      jQuery('#deal_summary').limitValue(40, '#summary_counter');
      jQuery('#deal_description').limitValue(80, '#description_counter');      
      
    }
};