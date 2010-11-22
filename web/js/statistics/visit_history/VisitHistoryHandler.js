/**
 * @combine statistics
 */

var VisitHistoryHandler = {
  init: function() {    
    debug.log('[VisitHistoryHandler][init]');
    jQuery('input#date-from').datepicker({
      dateFormat: 'yy-mm-dd'       
    });
    jQuery('input#date-to').datepicker({
      dateFormat: 'yy-mm-dd'       
    });
  }
}