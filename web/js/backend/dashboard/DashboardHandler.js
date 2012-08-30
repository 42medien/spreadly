/**
 * @nocombine backend
 */
var Dashboard = {
    
    init: function() {
      debug.log('[Dashboard][init]');          
      Dashboard.getUser();      
      
    },
    
    getUser: function() {
      debug.log('[Dashboard][getUser]');                
      jQuery('.show-more-link').live('click', function() {
        DashboardWidget.init(this);
        var options = {
            data : {
              ei_kcuf : new Date().getTime()
            },
            url: 'dashboard/get_top_user',            
            type : 'POST',
            dataType : 'json',
            success : function(pResponse) {
              DashboardWidget.expand(pResponse.html);
            }
          };
          jQuery('#db-range-form').ajaxSubmit(options);        
          
          return false;
      });
    }
    

};

var DashboardWidget = {
    
    aLinkObj: undefined,
    aThis: {},
    aThisId: {},
    aOrignWidth: undefined,
    aOrignHeight: undefined,
    
    init: function(pLinkObj) {
      DashboardWidget.aLinkObj = pLinkObj; 
      DashboardWidget.aThis = jQuery(pLinkObj).closest('.widget');
      DashboardWidget.aOrignWidth = jQuery(DashboardWidget.aThis).width();
      DashboardWidget.aOrignHeight = jQuery(DashboardWidget.aThis).height();
      DashboardWidget.aThisId = jQuery(DashboardWidget.aThis).attr('id');
      DashboardWidget.reduce();
    },
  
    expand: function(pHtml) {
      debug.log('[DashboardWidget][expand]');       
      jQuery("div.widget").not("#top-liker-widget").css({
        'opacity':'0.3',
        'z-index':'0'
      });              
        
      //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").hide();
      jQuery("#top-liker-widget .widget-data-section").css('height','auto');        
      //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").empty();
      jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").append(pHtml);
      jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").css('overflow-y', 'hidden');
      jQuery(DashboardWidget.aThis).css({'z-index': '999999', 'position':'absolute'});      
      
      var lEffectOptions = { to: { height: 400, width: 344 }};
      jQuery( "#top-liker-widget" ).effect( 'size', lEffectOptions, 500, DashboardWidget.expandCallback );        
    },
    
    expandCallback: function() {
      debug.log('[DashboardWidget][effectCallback]');   
      //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").show('slow');
      //jQuery("#top-liker-widget").css('height', 'auto');  
      DashboardWidget.toggleLink('show-less-link', 'show-more-link');
    },
    
    toggleLink: function(pAdd, pRemove) {
      jQuery(DashboardWidget.aLinkObj).text('dumdidum');
      jQuery(DashboardWidget.aLinkObj).removeClass(pRemove);
      jQuery(DashboardWidget.aLinkObj).addClass(pAdd);
    },
    
    reduce: function() {
      jQuery('.show-less-link').live('click', function() {
        debug.log('[DashboardWidget][expand]');       
          
        //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").hide();
        //jQuery("#top-liker-widget .widget-data-section").css('height','auto');        
        //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").empty();
        //jQuery("#top-liker-widget .widget-data-section .widget-ordered-list").append(pHtml);
        //jQuery("#top-liker-widget").css('z-index', '999999');      
        
        var lEffectOptions = { to: { height: DashboardWidget.aOrignHeight, width: DashboardWidget.aOrignWidth }};
        jQuery( "#top-liker-widget" ).effect( 'size', lEffectOptions, 500, DashboardWidget.reduceCallback);  
        jQuery("div.widget").css({
          'opacity':'1.0'
        });           
        
        jQuery('#'+DashboardWidget.aThisId+" ol li:gt(5)").remove();
        jQuery(DashboardWidget.aThis).css('margin-left', '0');
        return false;
      });      
    },
    
    reduceCallback: function() {
      jQuery(DashboardWidget.aThis).css({'z-index': '999999', 'position':'relative'});                  
      DashboardWidget.toggleLink('show-more-link', 'show-less-link');      
    }
};