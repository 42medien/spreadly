/**
 * @nocombine statistics
 */

/**
 * Class to handle reach counter on the tag selection
 * 
 * @author KM
 */
var Reach = {
    
  aTagModel: "",
  
  init: function() {
    Reach.getCounts();
    
  },
  
  getCounts: function() {
    debug.log("[Reach][getCounts]");
    var lTerms = Utils.trim(jQuery('#tags').val());
    jQuery.ajax({
      type: "GET",
      url: '/deals/get_tag_counts?model='+Reach.getVisibility()+'&term='+lTerms,
      dataType: "json",
      success: function (pResponse) {
          Reach.actualize(pResponse);
        }      
      });
  },
  
  actualize: function(pCounts) {
    debug.log(pCounts);
    for(var lUserKey in pCounts.user) {
      jQuery('#count-'+lUserKey).text(pCounts.user[lUserKey]);  
    }
    
    for(var lServiceKey in pCounts.services) {
      jQuery('#count-'+lServiceKey).text(pCounts.services[lServiceKey]);  
    }  
    
    for(var lWebsiteKey in pCounts.websites) {
      jQuery('#count-'+lWebsiteKey).text(pCounts.websites[lWebsiteKey]);  
    }     
    
  },
  
  getVisibility: function() {
    Reach.aTagModel = 'all';
    if(jQuery("#tag_model_dp").is(':checked') && !jQuery("#tag_model_user").is(':checked')){
      Reach.aTagModel = 'dp';
    } else if (jQuery("#tag_model_user").is(':checked') && !jQuery("#tag_model_dp").is(':checked')) {
      Reach.aTagModel = 'user';
    }
    
    return Reach.aTagModel;
  }
};