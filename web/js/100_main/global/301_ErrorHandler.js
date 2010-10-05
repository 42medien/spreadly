/**
 * @combine platform
 * @combine likepopup
 */

/**
 * class to handle the logging for thrown errors
 * @author KM
 * @version 1.0
 */
var ErrorLogger = {
	//global var for error-msg send to action
  aErrorMsg: 'Something went wrong',
  //global var for user-agend send to action
  aBrowserInfo: '',
    
  /**
   * handles the correct login on dev or live-system
   * @author KM
   * @version 1.0
   * @param string pMessage
   * @param string pFileName
   * @param string pLineNumber
   */
  initLog: function(pMessage, pFileName, pLineNumber) {
    OnLoadGrafic.hideGrafic();
    ErrorLogger.aErrorMsg = 'JS-Error: '+pMessage+' in ['+pFileName+'] on line ['+pLineNumber+']';
    ErrorLogger.aBrowserInfo = ErrorLogger.getBrowserInfo();
    ErrorLogger.doLog();
  },
	  
  /**
   * sends the error-infos to logging-action and to console
   * @author KM
   */
  doLog: function() {
    //if we are on a dev-system: log
    if(ErrorHandler.aDev == 1) {
    	//take the messages as post-params   
    	var options = {
    		'msg':ErrorLogger.aErrorMsg,
    		'useragent': ErrorLogger.aBrowserInfo
    	}; 
      //and send the request
      jQuery.ajax({
        type: "POST",
        url: 'general/js_log',
        dataType: "json",
        data: options
      });      
    }
  },
  
  /**
   * returns the BrowserInfo from UserAgent as string
   * @author KM
   * @return string lBrowserInfo
   */
  getBrowserInfo: function() {
  	var lBrowserInfo = '';
  	//call the jquery-browser-object and build a msg-string from the info
    jQuery.each(jQuery.browser, function(i, val) {
    	lBrowserInfo = lBrowserInfo+' '+i+' '+val;
    }); 
    return lBrowserInfo;	
  }
};


 /**
  * ErrorHandler: Methods to handle js-errors
  * @author KM
  * @version 1.0
  */

var ErrorHandler = {
	
	aDev: 0,
  
 /**
  * catches the xhr-errors (called as callback in jquery.ajax.error)
  * @author KM
  * @param object xhr
  * @param string ajaOptions
  * @param string thrownError
  * @param string pFile
  * @param string pLineNumber
  * @version 1.0
  */  
  catchXhrError: function(xhr, ajaxOptions, thrownError, pFile, pLineNumber){

  	var lMsg = '';
  	//if thrown error is set
  	if(thrownError !== undefined) {
  		lMsg = thrownError;
  	} else {
  		lMsg = xhr.statusText;
  	}
    //build error message  	
  	var lMessage = 'Status '+xhr['status']+' - '+lMsg;
  	//if file/method where error thrown isn't set
  	if(pFile === undefined) {
  		pFile = '';
  	}
  	//if linenumber, where error thrown is undefined
  	if(pLineNumber === undefined) {
  		pLineNumber = '';
  	}
  	//init the logger with msg, filename and linenumber if is set
    ErrorLogger.initLog(lMessage, pFile, pLineNumber);
    OnLoadGrafic.hideGrafic();
    return true;
  },
  
  /**
   * catches all window errors
   */
  catchGlobalError: function(){
  	//if global window error
		window.onerror = function(pMessage, pFileName, pLineNumber){
			//init logger
      ErrorLogger.initLog(pMessage, pFileName, pLineNumber);
      //and return true
      return true;
		}; 	
  },
  
  catchConsoleError: function() {
    if(typeof console == "undefined" || !console) {
      return C;
    } else {
      return console;
    }
  }
};

var AuthError = {
  redirect: function(pResponse) {
    window.location.href = pResponse.path;
  }    
};
