/**
 * Class to handle all effects for the whole stream
 * @author KM
 * @version 1.0
 * @nocombine platform
 */

var Stream = {
	
	show: function(pResponse) { 
		console.log("[Stream][show]");
		jQuery('#stream_left_bottom').empty();
		jQuery('#stream_left_bottom').append(pResponse.stream); 
		SubFilter.setAction(pResponse.action);
    MainFilter.updateData(pResponse.dataobj);		
    StreamFilter.updateCss(pResponse.css);
	}
};

var StreamFilter = {
	updateCss: function(pCssObj) {
    var lCssObj = jQuery.parseJSON(pCssObj);
    var lCssId = lCssObj['id'];
    var lCssClass = lCssObj['class'];
    if(lCssId == 'main_nav_outer'){
      MainFilter.removeCss();
      jQuery('#'+lCssId).addClass(lCssClass);
    } else {
      SubFilter.removeCss();
      ClassHandler.removeClassesByParent(jQuery('.lCssClass'), 'filter_chosen');
      jQuery('#'+lCssId).addClass('filter_chosen');
    }
	}
}


var SubFilter = {

  aAction: 'stream/new',
  
  setAction: function(pAction) {
    console.log("[SubFilter][setAction]");  	
    SubFilter.aAction = pAction;
  },
  
  getAction: function() {
    console.log("[SubFilter][getAction]");  	
  	return SubFilter.aAction;
  },
  
  removeCss: function(pCss) {
    console.log("[SubFilter][updateCss]");     	
    ClassHandler.removeClassesByParent(jQuery('#all_networks_list'), 'filter_chosen');
    ClassHandler.removeClassesByParent(jQuery('#friends_active_list'), 'filter_chosen');    
  }
};


var MainFilter = {
	
	aDataObj: {},
	
  updateData: function(pDataObj) {
    console.log("[MainFilter][update]");     	
  	MainFilter.aDataObj = jQuery.parseJSON(pDataObj);
    jQuery.each(jQuery('.main_filter'), function(i, pField) {
      MainFilter.setData(this);
    });
  },
  
  setData:  function(pElement) {
    console.log("[MainFilter][setData]");     	
  	var lData = '';
    if(jQuery(pElement).attr('data-obj')){ 
		  var lData = jQuery.parseJSON(jQuery(pElement).attr('data-obj'));
		  for(var lDataKey in lData) {
		    for(var lMainFilterKey in MainFilter.aDataObj) {
	        if(lDataKey == 'comid' || lDataKey == 'userid'){
	          delete lData[lDataKey];
	        }		    	
		      if(lDataKey != lMainFilterKey) {
	        	lData[lMainFilterKey] = MainFilter.aDataObj[lMainFilterKey];
		      }
		    }
		  }
		  lData = JSON.stringify(lData); 
    } else {
    	ErrorLogger.initLog('Missing data attribute','StreamHandler','66');
    }
    jQuery(pElement).attr('data-obj', lData);
  },
  
  removeCss: function(pCss) {
    console.log("[MainFilter][updateCss]");    	
    var lOuter = jQuery('#main_nav_outer');
    jQuery(lOuter).removeClass('whats_hot_active');
    jQuery(lOuter).removeClass('whats_not_active');
    jQuery(lOuter).removeClass('whats_new_active');   
  }  
}