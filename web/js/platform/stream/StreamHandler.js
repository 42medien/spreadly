/**
 * @nocombine platform
 */
 
 
 
/**
 * Class to handle glboal stream effects
 * @author KM
 * @version 1.0
 */
var Stream = {
	
	/**
	 * Callback-Function for the click to on a filter to load the stream
	 * @author KM
	 * @param object pResponse(JSON) 
	 */
	show: function(pResponse) { 
		console.log("[Stream][show]");
		console.log(pResponse.page);
		if(pResponse.page < 1 || pResponse.page == undefined) {
			//empty the stream
			jQuery('#stream_left_bottom').empty();
		}
		jQuery('#main_stream_pager').remove();
		//append the new
		jQuery('#stream_left_bottom').append(pResponse.stream);
		//set the action for next requests global 
		SubFilter.setAction(pResponse.action);
		//update the data-obj attribute of the filter
		MainFilter.setAction(pResponse.action);
    MainFilter.updateData(pResponse.dataobj);
    DataObjectPager.update('stream_pager_link', pResponse.action, pResponse.page, MainFilter.aDataObj);    
    //do some css-effects
    StreamFilter.updateCss(pResponse.css);
	}
};


/**
 * Object to handle the global behaviour of the filters
 * @author KM
 */
var StreamFilter = {
	
	/**
	 * handles the update of the css-attributes of the filter
	 * @author KM
	 * @param object pCssObj(JSON)
	 */
	updateCss: function(pCssObj) {
		if(pCssObj) {
			//get the css class and id that you wanna change
	    var lCssObj = jQuery.parseJSON(pCssObj);
	    var lCssId = lCssObj['id'];
	    var lCssClass = lCssObj['class'];
	    //if you wanna update the main-nav
	    if(lCssId == 'main_nav_outer'){
	    	//remove the current highlighting
	      MainFilter.removeCss();
	      //and add the new for highlighting
	      jQuery('#'+lCssId).addClass(lCssClass);
	    } else {
	    	//if u wanna change the subnavi on sidebar
	    	//remove the current highlighting
	      SubFilter.removeCss();
	      //and highlight the new
	      jQuery('#'+lCssId).addClass('filter_chosen');
	    }
		}
	}
};

/**
 * Handles the behaviour of the subfilters on sidebar (user and com-filter)
 * @author KM
 */
var SubFilter = {

  aAction: 'stream/hot',
  
  /**
   * set the action for the sub-filter-links global. The Action is defined in the last called action, e.g. new (response.action)
   * @author KM
   * @param string pAction
   */
  setAction: function(pAction) {
    console.log("[SubFilter][setAction]");  	
    SubFilter.aAction = pAction;
  },
  
  /**
   * returns the current action-string. is called in GlobalRequest. ATTENTION: this is used as callback-function in the GlobalRequest. 
   * If is not set, the following requests on click on a filter will not work
   * @author KM
   */
  getAction: function() {
    console.log("[SubFilter][getAction]");  	
  	return SubFilter.aAction;
  },
  
  /**
   * remove all highlighs from the filter-list on sidebar
   * @author KM
   */
  removeCss: function() {
    console.log("[SubFilter][updateCss]"); 
    //remove all classes named filter-chosen from a parent-list called all_network_list    	
    ClassHandler.removeClassesByParent(jQuery('#all_networks_list'), 'filter_chosen');
    ClassHandler.removeClassesByParent(jQuery('#friends_active_list'), 'filter_chosen');    
  }
};

/**
 * Handles the behaviour of the tab-filter/main-navigation hot/not/new
 * @author KM
 */
var MainFilter = {
	
	aDataObj: {},
	aAction: 'stream/hot',
	
	/**
	 * parse the updated data-obj from the response
	 * @author KM
	 * @param object pDataObj(JSON)
	 */
  updateData: function(pDataObj) {
    console.log("[MainFilter][updateData]");
    //parse the request-data-obj and write it in global var 	
  	MainFilter.aDataObj = jQuery.parseJSON(pDataObj);
    jQuery.each(jQuery('.main_filter'), function(i, pField) {
      MainFilter.setData(this);
    });
  },
  
  getAction: function() {
  	return MainFilter.aAction;
  },
  
  setAction: function(pAction) {
  	MainFilter.aAction = pAction;
  },
  
  /**
   * merge the current data-obj of the main-navigation with the updated from request and insert it to the element
   * @author KM
   * @param object pElement(DOM)
   */
  setData:  function(pElement) {
    console.log("[MainFilter][setData]");  
  	var lData = '';
  	//if the element has a data-obj (!!!has to have)
    if(jQuery(pElement).attr('data-obj')){ 
    	//take the data-obj of the element and parse it to a js-object
		  lData = jQuery.parseJSON(jQuery(pElement).attr('data-obj'));
		  //loop over the dom-attr-obj
		  for(var lDataKey in lData) {
		  	//also loop over the request-data-obj
		    for(var lMainFilterKey in MainFilter.aDataObj) {
		    	//look if are set special params (if isset e.g. a comid or a userid, remove this params. This will reset with the params from request)
	        if(lDataKey == 'comid' || lDataKey == 'userid' ){
	          delete lData[lDataKey];
	        }	
	        
	        if(lMainFilterKey=='page') {
	        	delete MainFilter.aDataObj[lMainFilterKey];
	        }
	        //are there some new fields after the request? if so, update the data-attr-object with the elems from request-data-obj	
		      if(lDataKey != lMainFilterKey) {
	        	lData[lMainFilterKey] = MainFilter.aDataObj[lMainFilterKey];
		      }
		    }
		  }
      //object to json-string
      lData = JSON.stringify(lData);     		  
    } else {
    	ErrorLogger.initLog('Missing data attribute','StreamHandler','66');
    }

    //write the data-attr-object to the element in dom
    jQuery(pElement).attr('data-obj', lData);
  },
  
  /**
   * remove the current highlight from the tabs
   * @author KM
   */
  removeCss: function() {
    console.log("[MainFilter][updateCss]");    	
    var lOuter = jQuery('#main_nav_outer');
    jQuery(lOuter).removeClass('whats_hot_active');
    jQuery(lOuter).removeClass('whats_not_active');
    jQuery(lOuter).removeClass('whats_new_active');   
  }  
};

var StreamPager = {
	update: function(pData) {
		console.log(pData);
	}
};