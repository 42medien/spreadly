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