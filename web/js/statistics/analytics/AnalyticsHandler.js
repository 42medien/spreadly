/**
 * @nocombine statistics
 */


var AnalyticsTables = {
  
    init: function() {
      debug.log('[AnalyticsTables][init]');
      AnalyticsTables.initTablesorter("dash-website-table");
      AnalyticsTables.initTablesorter("dash-deal-table");
      AnalyticsTables.initTablesorter("dash-url-table");
      AnalyticsTables.initTablesorter("analytics-url-table");
      AnalyticsTables.initTablesorter("top-url-table");
      jQuery('#dash-deal-table').tableScroll({height: 200, flush: true});
      jQuery('#dash-website-table').tableScroll({height: 200, flush: true});
      jQuery('#dash-url-table').tableScroll({height: 200, flush: true});      
      jQuery('#analytics-url-table').tableScroll({height: 200, flush: true});
    },
    
    initTablesorter: function(pTableId) {
      debug.log('[AnalyticsTables][initTablesorter]');
      var lTableId = pTableId;
      var lObject = jQuery('#'+pTableId);
      jQuery(lObject).tablesorter({
        debug: false    
      });
      
      jQuery(lObject).bind("sortStart",function() { 
        OnLoadGrafic.showGrafic();
      }).bind("sortEnd",function() { 
        OnLoadGrafic.hideGrafic();
      });      
    }    
};

/**
 * Handles the main-filter form in top of analytics
 * @author KM
 */
var AnalyticsFilter = {
    
    /**
     * inits the filter-ajax-functions 
     * @author KM
     */
    init: function() {
      debug.log('[AnalyticsFilter][init]');      
      //AnalyticsFilter.sendForm();
      AnalyticsFilter.initDatepicker();
      AnalyticsFilter.initDropdown();
    },
    
    initDropdown: function() {
      jQuery("select#filter_period").jgdDropdown({callback: function(obj, val) {
        AnalyticsFilter.getContent(val);
      }});      
    },
    
    getContent: function() {
      OnLoadGrafic.showGrafic();
      var options = {
        data : {
          ei_kcuf : new Date().getTime()
        },
        type : 'POST',
        dataType : 'json',
        success : function(pResponse) {
          debug.log(pResponse);
          AnalyticsFilter.showContent(pResponse.content);
          OnLoadGrafic.hideGrafic();
        }
      };
      jQuery('#analytics-filter-form').ajaxSubmit(options);       
    },
    
    showContent: function(pHtml) {
      jQuery('#domain-detail-content').empty();
      jQuery('#domain-detail-content').append(pHtml);
    },
    
    initDatepicker: function(){
      jQuery('#datefrombox').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
          jQuery('input#date-filter-from').val(dateText);
        }

      });

      jQuery('#datetobox').datepicker({
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, inst) {
          jQuery('input#date-filter-to').val(dateText);
        }
      });
    },  
    
    /**
     * binds the click to the form and sends the values to the specified action
     * @author KM
     */
    sendForm: function() {
      debug.log('[AnalyticsFilter][sendForm]');        
      jQuery('#analytics-filter-button').bind('click', function() {
        OnLoadGrafic.showGrafic();
        var options = {
            data : {
              ei_kcuf : new Date().getTime()
            },
            type : 'POST',
            dataType : 'json',
            success : function(pResponse) {
              AnalyticsFilterNav.show(pResponse.nav);
              AnalyticsFilterContent.show(pResponse.content);
              OnLoadGrafic.hideGrafic();
            }
          };
           jQuery('#analytics-filter-form').ajaxSubmit(options); 
           return false;
      });
    }
};

/**
 * handles the behaviour of the content (charts...)
 * @author KM
 */
var AnalyticsFilterContent = {
  show: function(pContent){
    debug.log('[AnalyticsFilterContent][show]');      
    jQuery('#analytix-content-box').empty();
    jQuery('#analytix-content-box').append(pContent);    
  }
};