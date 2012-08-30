/**
 * @combine statistics
 */


var AnalyticsTables = {
  
    /**
     * inits the js-functions of the analytics tables, like scroll and sort
     * @author KM
     */
    init: function() {
      debug.log('[AnalyticsTables][init]');
      AnalyticsTables.initTablesorter("dash-website-table");
      AnalyticsTables.initTablesorter("dash-deal-table");
      AnalyticsTables.initTablesorter("dash-url-table");
      AnalyticsTables.initTablesorter("analytics-url-table");
      AnalyticsTables.initTablesorter("top-url-table");
      AnalyticsTables.initTablesorter("top-like-table");
      
      jQuery('#dash-deal-table').tableScroll({height: 200, flush: true});
      jQuery('#dash-website-table').tableScroll({height: 150, flush: true});
      jQuery('#dash-url-table').tableScroll({height: 200, flush: true}); 
      jQuery('#analytics-url-table').tableScroll({height: 200, flush: true});
      jQuery('#top-url-table').tableScroll({height: 150, flush: true});
      jQuery('#top-like-table').tableScroll({height: 150, flush: true});
      
      jQuery('.myqtip').qtip({
//        style: { name: 'cream' },
        position: {
           corner: {
              target: 'rightTop',
              tooltip: 'leftBottom'
            },
            adjust:{
              x: 10
            }            
        },
        style: {
          border: {
             width: 5,
             radius: 10
          },
          padding: 10, 
          textAlign: 'center',
          tip: true,
          name: 'blue' // Style it according to the preset 'cream' style
       }
      });      
      
    },
    
    /**
     * inits the table-sorter-plugin
     * @author KM
     * @param pTableId
     */
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
      AnalyticsFilter.initDropdown();
    },
    
    /**
     * inits the request on the date-range-dropdown
     * @author KM
     */
    initDropdown: function() {
      debug.log('[AnalyticsFilter][initDropdown]');         
      jQuery("select#filter_period").jgdDropdown({callback: function(obj, val) {
        //prefer the dd-fields an delete from-to-values
        jQuery('#datefromfield').val('');
        jQuery('#datetofield').val('');
        //after selection, get the right content
        AnalyticsFilter.getContent(val);
      }});      
    },
    
    /**
     * sends a request and gets the selected content
     * @author KM
     */
    getContent: function() {
      debug.log('[AnalyticsFilter][getContent]');        
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
    
    /**
     * shows the content
     * @author KM
     * @param pHtml
     */
    showContent: function(pHtml) {
      debug.log('[AnalyticsFilter][showContent]');          
      jQuery('#domain-detail-content').empty();
      jQuery('#domain-detail-content').append(pHtml);
    }
};


/**
 * class to handle the date-selection in layer
 */
var AnalyticsDateFilter = {
    
    init: function() {
      debug.log('[AnalyticsDateFilter][init]');        
      AnalyticsDateFilter.initDatepicker();
      AnalyticsDateFilter.closeLayer();      
    },
    
    
    /**
     * inits the datepicker-plugin (jquery-ui) on layer
     */
    initDatepicker: function(){
      debug.log('[AnalyticsDateFilter][initDatepicker]');          
      jQuery('#datetobox').datepicker({
        dateFormat: 'yy-mm-dd',
        defaultDate: jQuery('input#date-filter-to').val(), 
        minDate: jQuery('input#date-filter-from').val(),
        onSelect: function(dateText, inst) {
          //updates the input-fields
          jQuery('input#date-filter-to').val(dateText);
        }
      });
      
      //get the dateto-instance of the datepicker to manipulate it after select an datefrom-date
      var lToInstance = jQuery("#datetobox").data('datepicker');

      jQuery('#datefrombox').datepicker({
        dateFormat: 'yy-mm-dd',
        defaultDate: jQuery('input#date-filter-from').val(),
        onSelect: function(dateText, inst) {
          jQuery('input#date-filter-from').val(dateText);
          //set the mindate of the dateto-datepicker to the selected datefrom
          lToInstance.settings.minDate = new Date(dateText);
          jQuery("#datetobox").datepicker("refresh");
        }
      });      
      
    },  
    
    /**
     * send request after closing the layer
     * @author KM
     * @param pAction
     */
    closeLayer: function() {
      debug.log('[AnalyticsDateFilter][closeLayer]');      
      
      jQuery('#close-layer-link').live('click', function() {
        var lAction = jQuery(this).attr('href');
        AnalyticsDateFilter.sendForm(lAction);
        return false;
      });
    },
    
    /**
     * send the form with the selected dates and get the content
     * @author KM
     * @param pAction
     * @returns {Boolean}
     */
    sendForm: function(pAction) {
      debug.log('[AnalyticsDateFilter][sendForm]');
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
            AnalyticsTables.init();            
            OnLoadGrafic.hideGrafic();
            jQuery.colorbox.close();
          }
        };
         jQuery('#analytics-datefilter-form').ajaxSubmit(options); 
         return false;      
    }
    
};