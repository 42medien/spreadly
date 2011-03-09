/**
 * @combine widget
 */

var DealsFilterList = {
    
    init: function() {
      DealsFilterList.getCoupon();
    },
    
    getCoupon: function() {
      jQuery('#show-deal-list .show-deal-link').live('click', function() {
        OnLoadGrafic.showGrafic();
        var lThis = this;
        var lAction = jQuery(this).attr('href');
        var lData = {
          ei_kcuf : new Date().getTime()
        };
        
        jQuery.ajax({
          //beforeSubmit : OnLoadGrafic.showGrafic,
          type : "POST",
          url : lAction,
          dataType : "json",
          data : lData,
          success : function(pResponse) {
            DealsFilterList.showCoupon(pResponse.html);
            DealsFilterList.setCss(lThis);
          }
        });
        
        return false;
      });
    },
    
    showCoupon: function(pHtml) {
      jQuery('#coupon-used-box').hide();
      jQuery('#coupon-used-box').empty();
      jQuery('#coupon-used-box').append(pHtml);
      jQuery('#coupon-used-box').slideDown();
      OnLoadGrafic.hideGrafic();
    },
    
    setCss: function(pThis) {
      jQuery('.show-deal-link').removeClass('active');
      jQuery(pThis).addClass('active');
    }
};