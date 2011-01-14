var AnalyticsFilter = {
    init: function() {
      AnalyticsFilter.toggleCheckboxes();
      jQuery('#advanced-options-link').toggleboxes({
        "id":"advanced-options-box"
      });
      AnalyticsFilter.sendForm();
    },
    
    toggleCheckboxes: function() {
      jQuery('#check-cats-link').live('click', function() {
        jQuery('#filter-category-list [type="checkbox"]').each(function() {
          jQuery(this).attr('checked', true);
        });
        return false;
      });
      
      jQuery('#uncheck-cats-link').live('click', function() {
        jQuery('#filter-category-list [type="checkbox"]').each(function() {
          jQuery(this).attr('checked', false);
        });
        return false;
      });      
      
    },
    
    sendForm: function() {
      jQuery('#analytics-filter-button').bind('click', function() {
        OnLoadGrafic.showGrafic();
        var options = {
            //beforeSubmit : OnLoadGrafic.showGrafic,
            //url : '/deals/save',
            data : {
              ei_kcuf : new Date().getTime()
            },
            type : 'POST',
            dataType : 'json',
            // resetForm: lReset,
            success : function(pResponse) {
              FilterNav.show(pResponse.nav);
              FilterContent.show(pResponse.content);
              OnLoadGrafic.hideGrafic();
            }
          };
          
           jQuery('#visit-history-form').ajaxSubmit(options); 
           return false;
      });
    }
};

var FilterNav = {
    init: function(){
      debug.log('[FilterNav][init]');
      FilterNav.bindClick();
      FilterNav.initDatepicker();
      
    },
    
    initDatepicker: function(){
      jQuery('input#date-from').datepicker({
        dateFormat: 'yy-mm-dd'       
      });
      jQuery('input#date-to').datepicker({
        dateFormat: 'yy-mm-dd'       
      });
    },
    
    bindClick: function() {
      debug.log('[FilterNav][bindClick]');      
      jQuery('.analytix-filter-link').live('click', function() {
        OnLoadGrafic.showGrafic();        
        FilterNav.getContent(this);
        return false;  
      });
    },
    
    getContent: function(pElem){
      debug.log('[FilterNav][getContent]');       
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
          debug.log(pResponse);
          //FilterNav.show(pResponse.nav);
          FilterContent.show(pResponse.content);
          OnLoadGrafic.hideGrafic();
        }
      });
    },
    
    show: function(pNav){
      jQuery('#analytix-filter-nav-box').empty();
      jQuery('#analytix-filter-nav-box').append(pNav);
    }
};

var FilterContent = {
  show: function(pContent){
    jQuery('#analytix-content-box').empty();
    jQuery('#analytix-content-box').append(pContent);    
  }
};