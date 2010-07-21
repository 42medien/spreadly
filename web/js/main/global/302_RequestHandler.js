/**
 * GlobalRequest: Binds the clicks and sends the request to the specified Action
 * Response will be handled in the specified callback
 * 
 * @author KM
 * @version 1.0
 * @nocombine platform
 */

var GlobalRequest = {
	
	aAction: '',
	aCallback: '',
	aParams: {},
	
	/**
	 * check if the element is a link. if so, it calls the setGlobalsByUri, if not, call setGlobalsByObject or the setglobalbydata
	 * @author KM
	 * @param object pElement
	 * @param object pParams
	 */
	initGlobals: function(pElement, pParams) {
		console.log("[GlobalRequest][initGlobals]");
		//is the given element an link
    if(jQuery(pElement).is('a') && !jQuery(pElement).attr('data-obj') && !jQuery(pElement).attr('onclick')) {
    	//set the global vars in the setGlobalsByUri method
      GlobalRequest.setGlobalsByUri(jQuery(pElement).attr('href'));
    } else if(pParams != undefined) {
    	//if the element is not a link, set the global vars in setGlobalsByObject
      GlobalRequest.setGlobalsByObject(pParams);
    }	else {
    	//if no href and no params, the element has to have an data-obj attribute with the settings and params
    	GlobalRequest.setGlobalByData(pElement);
    }
	},
	
	/**
	 * extract the callback-param from the href-attribute and 
	 * @author KM
	 * @param string pHref (have to look like that: http://example.com?callback=MYCALLBACK()&param=PARAM)
	 */
	setGlobalsByUri: function(pHref) {
    console.log("[GlobalRequest][setGlobalsByUri]");		
		//take the callback from the href-uri
    GlobalRequest.aCallback = pHref.match(/([?&]callback[a-zA-Z0-9=\.]+)/)[0].split('=')[1];
    //and delete it from it, because we dont need twice the same param 
    GlobalRequest.aAction = pHref.replace(/([?&]callback[a-zA-Z0-9=\.]+[&])/, "?");
	},
	
	/**
	 * extract action, callback and params from the given param-object
	 * have to look like that: {"action":"module/action", "callback":"MYCALLBACK()", "param":"param"}
	 * @author KM
	 * @param object pParams
	 */
	setGlobalsByObject: function(pParams) {
    console.log("[GlobalRequest][setGlobalsByObject]");		
		//set global action and callback vars
		GlobalRequest.aAction = pParams.action;
		GlobalRequest.aCallback = pParams.callback;
		//delete them from the params, because we don't have to send them to the action
		delete pParams.action;
		delete pParams.callback;
		//and ste the global params var for the doSend
		GlobalRequest.aParams = pParams;
	},
	
  /**
   * extract action, callback and params from the data-obj attribute in the given element
   * have to look like that: data-obj = '{"action":"module/action", "callback":"MYCALLBACK()", "param":"param"}'
   * @author KM
   * @param object pElement
   */	
	setGlobalByData: function(pElement) {
    console.log("[GlobalRequest][setGlobalByData]");   		
		//take the data-obj attribute from the given element
		var lParams = jQuery(pElement).attr('data-obj');
		//parse it to a object
		lParams = jQuery.parseJSON(lParams);
		//lAction = jQuery.parseJSON(lParams.action);
    //set global action and callback vars
    GlobalRequest.aAction = GlobalRequest.parseAction(lParams.action);        
    GlobalRequest.aCallback = lParams.callback;
    //delete them from the params, because we don't have to send them to the action    
    delete lParams.action;
    delete lParams.callback;
    //and ste the global params var for the doSend    
    GlobalRequest.aParams = lParams;		
	},
	
	/**
	 * checks, if the action in data-obj is a real action string like "module/action" or a callback, what will used global like SubFilter.getAction
	 * if it is a callback, we get the action-string from that
	 * @author KM
	 * @param string pString
	 */
	parseAction: function(pString) {
    console.log("[GlobalRequest][parseAction]");    		
    var lAction = pString;
    //if there is a dot in the string, it is a callback-function if not, it is a action-string and we return it
    if(lAction.indexOf('.') != -1) {
    	//explode the string between the dot
    	var lArray = lAction.split('.');
    	//if the so called function exists
	    if(typeof window[lArray[0]][lArray[1]] == 'function') {
	    	//call it and write the result to local var
	      lAction = window[lArray[0]][lArray[1]]();  
	    }     	
    }
    return lAction;
	},
	
	/**
	 * bind a click-event to a object identified by css id
	 * initialized like this: GlobalRequest.bindClickById('mycssid', {"action":"module/action", "callback":"MYCALLBACK()", "param":"param"})
	 * if pParams is not set, the element with the pId have to be a a-tag with valid href (module/action?callback=MYCALLBACK()&param=PARAM)
	 * @author KM
	 * @param string pId
	 * @param object pParams
	 */
	bindClickById: function(pId, pParams) {
    console.log("[GlobalRequest][bindClickById]"); 		
		//get the element identified by the given id
		var lElement = jQuery('#'+pId);
		//init the global vars for dosend
		GlobalRequest.initGlobals(lElement, pParams);
		//bind the click to the element
    jQuery(lElement).live("click", function() {
      //and send request on click
      GlobalRequest.doSend();
      return false;
    });
	},
	
  /**
   * bind a click-event to a all child-objects of parentid with the given tag
   * initialized like this: GlobalRequest.bindClickByTag('ul-cssid', 'li',  {"action":"module/action", "callback":"MYCALLBACK()", "param":"param"})
   * if pParams is not set, the element with the pTagName have to be an data-obj attribute:
   * data-obj='{"action":"module/action", "callback":"MYCALLBACK()", "param":"param"}'
   * @author KM
   * @param string pParentId
   * @param string pTagName
   * @param object pParams
   */	
	bindClickByTag: function(pParentId, pTagName, pParams) {
    console.log("[GlobalRequest][bindClickByTag]");  		
		//bind the click to all tags that are childs of the given parentid -> ATTENTION: this is needed for performance. 
		//Never ever bind events to a tagname global
    jQuery('#'+pParentId+' '+pTagName).live("click", function() {
      //init the global vars for dosend    	
      GlobalRequest.initGlobals(this, pParams);   
      //and send request on click
      GlobalRequest.doSend();
      return false;
    }); 		
	},
	
  /**
   * bind a click-event to all child-objects of parentid with the given class
   * initialized like this: GlobalRequest.bindClickByTag('ul-cssid', 'li-child-with-class',  {"action":"module/action", "callback":"MYCALLBACK()", "param":"param"})
   * if pParams is not set, the element with the pClassName have to be an data-obj attribute:
   * data-obj='{"action":"module/action", "callback":"MYCALLBACK()", "param":"param"}'
   * @author KM
   * @param string pParentId
   * @param string pClassName
   * @param object pParams
   */ 	
  bindClickByClass: function(pParentId, pClassName, pParams) {
    console.log("[GlobalRequest][bindClickByClass]");     	
    //bind the click to all elements that are childs of the given parentid and has the given classname -> ATTENTION: this is needed for performance. 
    //Never ever bind events to a tagname global  	
    jQuery('#'+pParentId+' .'+pClassName).live("click", function() { 
      //init the global vars for dosend      	
      GlobalRequest.initGlobals(this, pParams);
      //and send request on click      
      GlobalRequest.doSend();
      return false;
    });    	
  },	
  
  /**
   * binds a click-event to the given element
   * @author KM
   * @param object pElement
   * @param object pParames
   */
  bindClickByElement: function(pElement, pParams) {
    console.log("[GlobalRequest][bindClickByElement]");     	
  	jQuery(pElement).die('click');
  	jQuery(pElement).live("click", function() {
      GlobalRequest.initGlobals(pElement, pParams);  		
      //and send request on click      
      GlobalRequest.doSend();
      return false;  		
  	});
  },
	
	/**
	 * method called by the onclick-attribute: 
	 * onclick='GlobalRequet.initOnClick(this, {"action":"module/action", "callback":"MYCALLBACK()", "param":"param"})'
   * if pParams is not set, the clicked-element have to be an data-obj attribute:
   * data-obj='{"action":"module/action", "callback":"MYCALLBACK()", "param":"param"}'
   * @author KM
   * @param object pElement
   * @param object pParams
	 */
	initOnClick: function(pElement, pParams) {
    console.log("[GlobalRequest][initOnClick]");  		
    //init the global vars for dosend 
    GlobalRequest.initGlobals(pElement, pParams);  
    //and send request on click  
    GlobalRequest.doSend();
    return false;
	},
	
	
	/**
	 * sends the request to the global defined action with the global defined params. Default action type is get.
	 * the callback has also to be defined global. The callback is the method, that is executed after request.
	 * It is defined in the init of the click element or with an attribute (href, data-obj) of that
	 * @author KM
	 * @param string pActionType
	 */
	doSend: function(pActionType) {
    console.log("[GlobalRequest][doSend]");  		
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