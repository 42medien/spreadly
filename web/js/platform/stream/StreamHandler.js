/**
 * @combine platform
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
		debug.log("[Stream][show]");
		if(pResponse.page <= 1 || pResponse.page === undefined) {
			//empty the stream
			jQuery('#new_shares').empty();
		}
		jQuery('#main_stream_pager').remove();
		//append the new
		jQuery('#new_shares').append(pResponse.stream);
		//set the action for next requests global 
		StreamSubFilter.setAction(pResponse.action);
		//update the data-obj attribute of the filter
    MainFilter.updateData(pResponse.dataobj);
    
    if(pResponse.pDoPaginate == false) {
      jQuery('#stream_pager_link').hide();
    } else {
      //update the pager-settings -> with the append isset a new pager, that needs to be initialized
      if(jQuery('#stream_pager_link').css('display')=='none') {
        jQuery('#stream_pager_link').show();        
      }
      DataObjectPager.update('stream_pager_link', pResponse.action, pResponse.page, MainFilter.aDataObj, pResponse.css); 
    }    
   
    var lCssObj = jQuery.parseJSON(pResponse.css);
    //do some css-effects
    StreamFilter.updateCss(lCssObj);
    Stream.updateCss(lCssObj);
    OnLoadGrafic.hideGrafic();
    
    //load the details of the first element on the right sidebar
    ItemDetail.loadFirst();
	},
	
	/**
	 * updates the css of the stream
	 * @param pCssObj
	 */
	updateCss: function(pCssObj) {
    debug.log("[Stream][updateCss]");	  

    if(pCssObj && pCssObj['class'] != "normal_list") {
      jQuery('#new_shares').removeClass('not_stream');
      jQuery('#new_shares').removeClass('new_stream');
      jQuery('#new_shares').removeClass('hot_stream');
  	  if(pCssObj['class'] == 'whats_hot_active') {
  	    jQuery('#new_shares').addClass('hot_stream');
  	  } else if(pCssObj['class'] == 'whats_not_active') {
        jQuery('#new_shares').addClass('not_stream');	    
  	  } else if(pCssObj['class'] == 'whats_new_active') {
        jQuery('#new_shares').addClass('new_stream');	    
  	  }
    }
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
    debug.log("[StreamFilter][updateCss]");     
		if(pCssObj) {
			//get the css class and id that you wanna change
	    var lCssId = pCssObj['id'];
	    var lCssClass = pCssObj['class'];
	    //if you wanna update the main-nav
	    if(lCssId == 'main_nav_outer'){
	    	//remove the current highlighting
	      MainFilter.updateCss(lCssClass);
	    } else {
	    	//if u wanna change the subnavi on sidebar
	      StreamSubFilter.updateCss(lCssId);
	    }
		}
	}
};

/**
 * Handles the behaviour of the StreamSubFilters on sidebar (user and com-filter)
 * @author KM
 */
var StreamSubFilter = {

  aAction: 'stream/hot',
  
  /**
   * set the action for the sub-filter-links global. The Action is defined in the last called action, e.g. new (response.action)
   * @author KM
   * @param string pAction
   */
  setAction: function(pAction) {
    debug.log("[StreamSubFilter][setAction]");  	
    StreamSubFilter.aAction = pAction;
  },
  
  /**
   * returns the current action-string. is called in GlobalRequest. ATTENTION: this is used as callback-function in the GlobalRequest. 
   * If is not set, the following requests on click on a filter will not work
   * @author KM
   */
  getAction: function() {
    debug.log("[StreamSubFilter][getAction]");  	
  	return StreamSubFilter.aAction;
  },
  
  /**
   * remove all highlighs from the filter-list on sidebar
   * @author KM
   */
  updateCss: function(pCssId) {
    debug.log("[StreamSubFilter][updateCss]"); 
    //remove all classes named filter-chosen from a parent-list called all_network_list    	
    StreamSubFilter.resetCss();
    
    var lResetElemId = 'active_friends_headline';
    if(jQuery('#'+pCssId).parent('ul.normal_list').attr('id') == 'all_networks_list') {
      lResetElemId = 'active_communities_headline';
      FriendStream.reset();
      FriendStreamCounter.reset();
      FriendStreamInputFilter.reset();
      
    }
    FilterHeadline.updateCss(lResetElemId);
    
    //and highlight the new
    jQuery('#'+pCssId).addClass('filter_chosen');
  },
  
  resetCss: function() {
    debug.log("[StreamSubFilter][resetCss]"); 
    //remove all classes named filter-chosen from a parent-list called all_network_list     
    ClassHandler.removeClassesByParent(jQuery('#all_networks_list'), 'filter_chosen');
    ClassHandler.removeClassesByParent(jQuery('#friends_active_list'), 'filter_chosen');
    ClassHandler.removeClassesByParent(jQuery('#friends_all_list'), 'filter_chosen');   
    ClassHandler.removeClassesByParent(jQuery('#friends_search_results'), 'filter_chosen');    
  }
};

/**
 * Handles the behaviour of the tab-filter/main-navigation hot/not/new
 * @author KM
 */
var MainFilter = {
	
	aDataObj: {},
	
	/**
	 * parse the updated data-obj from the response
	 * @author KM
	 * @param object pDataObj(JSON)
	 */
  updateData: function(pDataObj) {
    debug.log("[MainFilter][updateData]");
    //parse the request-data-obj and write it in global var 	
  	MainFilter.aDataObj = jQuery.parseJSON(pDataObj);
    jQuery.each(jQuery('.main_filter'), function(i, pField) {
      MainFilter.setData(this);
    });
  },
  
  /**
   * merge the current data-obj of the main-navigation with the updated from request and insert it to the element
   * @author KM
   * @param object pElement(DOM)
   */
  setData:  function(pElement) {
    debug.log("[MainFilter][setData]");  
  	var lData = '';
  	var lIsDeleted = false;
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
	          lIsDeleted = true;
	        }
	        //are there some new fields after the request? if so, update the data-attr-object with the elems from request-data-obj	
		      if(lDataKey != lMainFilterKey || lIsDeleted === true) {
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
  updateCss: function(pCssClass) {
    debug.log("[MainFilter][updateCss]");    	
    var lOuter = jQuery('#main_nav_outer');
    jQuery(lOuter).removeClass('whats_hot_active');
    jQuery(lOuter).removeClass('whats_not_active');
    jQuery(lOuter).removeClass('whats_new_active'); 
    debug.log(pCssClass);
    jQuery(lOuter).addClass(pCssClass);
  }  
};