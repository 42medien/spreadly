/**
 * @combine statistics
 */

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
      AnalyticsFilter.sendForm();
      AnalyticsFilter.initDatepicker();      
    },
    
    initDatepicker: function(){
      jQuery('input#date-from').datepicker({
        dateFormat: 'yy-mm-dd'       
      });
      jQuery('input#date-to').datepicker({
        dateFormat: 'yy-mm-dd'       
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
 * Handles the filter navigation on sidebar left in analytics
 * @author KM
 */
var AnalyticsFilterNav = {
    
    aSelectedId: null,
    aSelectedElem: null,
    
    /**
     * inits the functions
     * @author KM
     */
    init: function(){
      debug.log('[AnalyticsFilterNav][init]');
      AnalyticsFilterNav.bindClick();
      
    },
    
    /**
     * binds the click to the filter-navi-elements
     * @author KM
     */
    bindClick: function() {
      debug.log('[AnalyticsFilterNav][bindClick]');      
      jQuery('.analytix-filter-link').live('click', function() {
        OnLoadGrafic.showGrafic();        
        if(jQuery(this).hasClass('url-filter-link')) {
          AnalyticsFilterNav.aSelectedId = jQuery(this).attr('id');
        } else if(jQuery(this).hasClass('table-filter-link')) {
          AnalyticsFilterNav.aSelectedId = 'url-filter-link-1';
        } else {
          AnalyticsFilterNav.aSelectedElem = this;
        }
        AnalyticsFilterNav.getContent(this);
        
        return false;  
      });
    },
    
    /**
     * ajax call to action specified in href of pElem
     * @author KM
     * @param object pElem
     */
    getContent: function(pElem){
      debug.log('[AnalyticsFilterNav][getContent]');       
      var lAction, lData;
      lAction = jQuery(pElem).attr('href');
      lData = {
          ei_kcuf : new Date().getTime()
      };
      
      jQuery.ajax({
        beforeSubmit : OnLoadGrafic.showGrafic,
        type : "GET",
        url : lAction,
        dataType : "json",
        data : lData,
        success : function(pResponse) {
          AnalyticsFilterContent.show(pResponse.content);
          if(pResponse.nav != undefined){
            AnalyticsFilterNav.show(pResponse.nav);            
          }
          AnalyticsFilterNav.highlight();
      
          OnLoadGrafic.hideGrafic();
        }
      });
    },
    
    highlight: function() {
      debug.log('[AnalyticsFilterNav][highlight]');
      debug.log('elem '+AnalyticsFilterNav.aSelectedElem);
      debug.log('id '+AnalyticsFilterNav.aSelectedId);
      jQuery('.analytix-filter-link').removeClass('active');
      if(AnalyticsFilterNav.aSelectedElem != null) {
        jQuery(AnalyticsFilterNav.aSelectedElem).addClass('active');  
        AnalyticsFilterNav.aSelectedElem = null;
      } else {
       jQuery('#'+AnalyticsFilterNav.aSelectedId).addClass('active');
      }
                
    },
    
    /**
     * displays the filter-nav
     * @author KM 
     * @param html pNav
     */
    show: function(pNav){
      debug.log('[AnalyticsFilterNav][show]');        
      jQuery('#analytix-filter-nav-box').empty();
      jQuery('#analytix-filter-nav-box').append(pNav);
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