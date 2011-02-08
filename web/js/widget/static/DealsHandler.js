var DealsFilterList = {
    
    init: function() {
      DealsFilterList.getCoupon();
    },
    
    getCoupon: function() {
      jQuery('#show-deal-list .show-deal-link').live('click', function() {
        OnLoadGrafic.showGrafic();
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime(),
        };
        
        jQuery.ajax({
          //beforeSubmit : OnLoadGrafic.showGrafic,
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            DealsFilterList.showCoupon(pResponse.html);
          }
        });
        
        return false;
      });
    },
    
    showCoupon: function(pHtml) {
      jQuery('#coupon-used-box').hide();
      jQuery('#coupon-used-box').empty();
      jQuery('#coupon-used-box').append(pHtml);
      jQuery('#coupon-used-box').show('slow');
      OnLoadGrafic.hideGrafic();
    }
};