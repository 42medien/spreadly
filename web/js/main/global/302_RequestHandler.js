/**
 * GlobalRequest: Binds the clicks and sends the request to the specified Action
 * Response will be handled in the specified callback
 * @author KM
 * @version 1.0
 * @combine platform
 */

var GlobalRequest = {
	
	aAction: '',
	aCallback: '',
	aParams: {},
	
	/**
	 * check if the element is a link. if so, it calls the setGlobalsByUri, if not, call setGlobalsByObject
	 * @author KM
	 * @param object pElement
	 * @param object pParams
	 */
	initGlobals: function(pElement, pParams) {
		//is the given element an link
    if(jQuery(pElement).is('a')) {
    	//set the global vars in the setGlobalsByUri method
      GlobalRequest.setGlobalsByUri(jQuery(pElement).attr('href'));
    } else if(pParams != undefined) {
    	//if the element is not a link, set the global vars in setGlobalsByObject
      GlobalRequest.setGlobalsByObject(pParams);
    }	else {
    	GlobalRequest.setGlobalByData(pElement);
    }
	},
	
	/**
	 * extract the callback-param from the href-attribute and 
	 */
	setGlobalsByUri: function(pHref) {
    GlobalRequest.aCallback = pHref.match(/([?&]callback[a-zA-Z0-9=\.]+)/)[0].split('=')[1];
    GlobalRequest.aAction = pHref.replace(/([?&]callback[a-zA-Z0-9=\.]+[&])/, "?");
	},
	
	setGlobalsByObject: function(pParams) {
		GlobalRequest.aAction = pParams.action;
		GlobalRequest.aCallback = pParams.callback;
		delete pParams.action;
		delete pParams.callback;
		GlobalRequest.aParams = pParams;
	},
	
	setGlobalByData: function(pElement) {
		var lParams = jQuery(pElement).attr('data-obj');
		lParams = jQuery.parseJSON(lParams);
    GlobalRequest.aAction = lParams.action;
    GlobalRequest.aCallback = lParams.callback;
    delete lParams.action;
    delete lParams.callback;
    GlobalRequest.aParams = lParams;		
	},
	
	bindClickById: function(pId, pParams) {
		var lElement = jQuery('#'+pId);
		GlobalRequest.initGlobals(lElement, pParams);
    jQuery(lElement).live("click", function() {
      GlobalRequest.doSend();
      return false;
    });
	},
	
	bindClickByTag: function(pParentId, pTagName, pParams) {
    jQuery('#'+pParentId+' '+pTagName).live("click", function() {
      GlobalRequest.initGlobals(this, pParams);      
      GlobalRequest.doSend();
      return false;
    }); 		
	},
	
  bindClickByClass: function(pParentId, pClassName, pParams) {
    jQuery('#'+pParentId+' .'+pClassName).live("click", function() { 
      GlobalRequest.initGlobals(this, pParams);
      GlobalRequest.doSend();
      return false;
    });    	
  },	
	
	initOnClick: function(pElement, pParams) {
    GlobalRequest.initGlobals(pElement, pParams);      
    GlobalRequest.doSend();
	},
	
	doSend: function(pActionType) {
		var lActionType = 'GET';
		if(pActionType) {
			lActionType = pActionType;
		}
    jQuery.ajax({
      type: 'GET',
      dataType:"jsonp",
      jsonpCallback: GlobalRequest.aCallback,
      error: ErrorHandler.catchXhrError,
      url: GlobalRequest.aAction,
      data: GlobalRequest.aParams
    });
	}
};