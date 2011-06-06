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
    }
};