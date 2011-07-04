/**
 * @nocombine statistics
 */


var DealAnalytics = {
    init: function() {
      debug.log('[DealAnalytics][init]');
      AnalyticsTables.initTablesorter("top-pages-table");    
      jQuery('#top-pages-table').tableScroll({height: 200, flush: true});      
      
    }
};