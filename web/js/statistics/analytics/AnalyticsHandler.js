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
      AnalyticsTables.initTablesorter("top-like-table");
      
      jQuery('#dash-deal-table').tableScroll({height: 200, flush: true});
      jQuery('#dash-website-table').tableScroll({height: 200, flush: true});
      jQuery('#dash-url-table').tableScroll({height: 200, flush: true}); 
      jQuery('#analytics-url-table').tableScroll({height: 200, flush: true});
      jQuery('#top-url-table').tableScroll({height: 150, flush: true});
      jQuery('#top-like-table').tableScroll({height: 150, flush: true});
      
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
      AnalyticsFilter.initDropdown();
    },
    
    initDropdown: function() {
      debug.log('[AnalyticsFilter][initDropdown]');         
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
          AnalyticsFilter.showContent(pResponse.content);
          AnalyticsTables.init();
          OnLoadGrafic.hideGrafic();
        }
      };
      jQuery('#analytics-filter-form').ajaxSubmit(options);       
    },
    
    showContent: function(pHtml) {
      jQuery('#domain-detail-content').empty();
      jQuery('#domain-detail-content').append(pHtml);
    }
};

var AnalyticsDateFilter = {
    
    initDatepicker: function(){
      jQuery('#datetobox').datepicker({
        dateFormat: 'yy-mm-dd',
        defaultDate: jQuery('input#date-filter-to').val(), 
        minDate: jQuery('input#date-filter-from').val(),
        onSelect: function(dateText, inst) {
          jQuery('input#date-filter-to').val(dateText);
        }
      });
      
      var lToInstance = jQuery("#datetobox").data('datepicker');

      jQuery('#datefrombox').datepicker({
        dateFormat: 'yy-mm-dd',
        defaultDate: jQuery('input#date-filter-from').val(),
        onSelect: function(dateText, inst) {
          jQuery('input#date-filter-from').val(dateText);
          //dates.not( this ).datepicker( "option", "minDate", dateText );
          var instance = jQuery(this).data('datepicker');
          lToInstance.settings.minDate = new Date(dateText);
          jQuery("#datetobox").datepicker("refresh");
        }
      });      
      
    },  
    
    closeLayer: function(pAction) {
      debug.log('[AnalyticsFilter][closeLayer]');         
      jQuery(document).bind('cbox_cleanup', function(){
        AnalyticsDateFilter.sendForm(pAction);
      }); 
    },
    
    sendForm: function(pAction) {
      debug.log('[AnalyticsFilter][sendDateForm]');
      OnLoadGrafic.showGrafic();      
      var options = {
          data : {
            ei_kcuf : new Date().getTime()
          },
          url: pAction,
          type : 'POST',
          dataType : 'json',
          success : function(pResponse) {
            debug.log(pResponse);
            AnalyticsFilter.showContent(pResponse.content);
            OnLoadGrafic.hideGrafic();
            jQuery(document).unbind('cbox_cleanup');
          }
        };
         jQuery('#analytics-datefilter-form').ajaxSubmit(options); 
         return false;      
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