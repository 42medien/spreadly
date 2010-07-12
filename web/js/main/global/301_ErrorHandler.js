/**
 * @nocombine platform
 */

var ErrorLogger = {
  aErrorMsg: 'Something went wrong',
  aBrowserInfo: 'Something went wrong',
  
  initLog: function(pMessage, pFileName, pLineNumber) {
    ErrorLogger.aErrorMsg = 'JS-Error: '+pMessage+' in ['+pFileName+'] on line ['+pLineNumber+']';
    jQuery.each(jQuery.browser, function(i, val) {
      ErrorLogger.aBrowserInfo = ErrorLogger.aBrowserInfo+' '+i+' '+val;
    });
    ErrorLogger.sendLog();
  },
  
  sendLog: function() {
    if(ErrorHandler.aDev == 1) {   
    	
    	var options = {
    		'msg':ErrorLogger.aErrorMsg,
    		'useragent': ErrorLogger.aBrowserInfo
    	}; 
      //sendrequest
      jQuery.ajax({
        type: "POST",
        url: 'http://www.yiid.local/general/js_log',
        dataType: "json",
        data: options,
        success: function() {
        
        }
      });      
      
      
      console.log(ErrorLogger.aErrorMsg);
    }
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
  * @version 1.0
  */  
  catchXhrError: function(xhr, ajaxOptions, thrownError, pFile, pLineNumber){
  	
  	var lMsg = '';
  	if(thrownError != undefined) {
  		lMsg = thrownError;
  	} else {
  		lMsg = xhr.statusText;
  	}
  	
  	var lMessage = 'Status '+xhr['status']+' - '+lMsg;
  	if(pFile === undefined) {
  		pFile = '';
  	}
  	if(pLineNumber === undefined) {
  		pLineNumber = '';
  	}
    ErrorLogger.initLog(lMessage, pFile, pLineNumber);
    return true;
  },
  
  /**
   * catches all window errors
   */
  catchGlobalError: function(){
		window.onerror = function(pMessage, pFileName, pLineNumber){
      ErrorLogger.initLog(pMessage, pFileName, pLineNumber);
      return true;
		}; 	
  }
};
