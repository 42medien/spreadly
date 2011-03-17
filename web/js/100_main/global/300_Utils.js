/**
 * @combine platform
 * @combine likepopup
 * @combine statistics
 * @combine widget
 */

/**
  * General JavaScript-File for Yiid.com
  *
  * @copyright 2009 Yiid.com
**/

/**
  * UtilsObject: object with some helpful js- operations
  * @author KM
  * @version 1.0
  */
var Utils = {

  /**
   * splits an given string by given delimiter and returns the two parts as an array
   * @param string pDelimiter
   * @param string pString
   * @return array lCleanedArray
   */
  explode: function(pDelimiter, pString) {
    var lArray = pString.split(pDelimiter);
    var lCleanedArray = new Array();
    var lCounter = 0;

    for(var i = 0; i < lArray.length; i++) {
      var lCleaned = lArray[i].replace (/^\s+/, '').replace (/\s+$/, '');
      lCleaned = lCleaned.replace (new RegExp(pDelimiter, "i"), '');
      if(lCleaned != '') {
        lCleanedArray[lCounter] = lCleaned;
        lCounter++;
      }
    }
    return lCleanedArray;
  },

  /**
   * finds the string needle in the array haystack
   * @param string pNeedle
   * @param array pHaystack
   * @return boolean lIsin
   */
  in_array: function(pNeedle, pHaystack) {
    var lIsin = false;
    for(var j = 0; j < pHaystack.length; j++) {
      if(pHaystack[j].toLowerCase() == pNeedle.toLowerCase()) {
        lIsin  = true;
      }
    }
    return lIsin;
  },

  /**
   * remove all spaces in a given string
   * @author KM
   * @param string pString
   * @return string
   */
  trim: function (pString) {
    var cleanedString = pString.replace(/^\s+/,'').replace(/\s+$/,'');
    return cleanedString;
  },

  ltrim: function(pString) {
    return pString.replace(/^\s+/,"");
  },

  rtrim: function(pString) {
    return pString.replace(/\s+$/,"");
  },

  lrtrim: function(pString) {
    return pString.replace(/^\s+|\s+$/g,"");
  },

  checkBrowserName: function (name){
    var agent = navigator.userAgent.toLowerCase();
    if (agent.indexOf(name.toLowerCase())>-1) {
      return true;
    }
    return false;
  },

  getParams: function() {
   debug.log('[Utils][getParams]');
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++)
    {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
  },

  /**
   * @description returns the current time
   */
  getTimestamp: function() {
    return new Date().getTime();
  },

  /**
   * @description check if an element exists in markup
   */
  elementExists: function(pElement) {
    if(pElement === undefined || pElement == '' || pElement == null || pElement.length == 0) {
      return false;
    } else {
      return true;
    }
  },

	urlencode: function (str) {
	    // URL-encodes string
	    //
	    // version: 1004.2314
	    // discuss at: http://phpjs.org/functions/urlencode
	    // +   original by: Philip Peterson
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: AJ
	    // +   improved by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: Brett Zamir (http://brett-zamir.me)
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +      input by: travc
	    // +      input by: Brett Zamir (http://brett-zamir.me)
	    // +   bugfixed by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
	    // +   improved by: Lars Fischer
	    // +      input by: Ratheous
	    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
	    // +   bugfixed by: Joris
	    // +      reimplemented by: Brett Zamir (http://brett-zamir.me)
	    // %          note 1: This reflects PHP 5.3/6.0+ behavior
	    // %        note 2: Please be aware that this function expects to encode into UTF-8 encoded strings, as found on
	    // %        note 2: pages served as UTF-8
	    // *     example 1: urlencode('Kevin van Zonneveld!');
	    // *     returns 1: 'Kevin+van+Zonneveld%21'
	    // *     example 2: urlencode('http://kevin.vanzonneveld.net/');
	    // *     returns 2: 'http%3A%2F%2Fkevin.vanzonneveld.net%2F'
	    // *     example 3: urlencode('http://www.google.nl/search?q=php.js&ie=utf-8&oe=utf-8&aq=t&rls=com.ubuntu:en-US:unofficial&client=firefox-a');
	    // *     returns 3: 'http%3A%2F%2Fwww.google.nl%2Fsearch%3Fq%3Dphp.js%26ie%3Dutf-8%26oe%3Dutf-8%26aq%3Dt%26rls%3Dcom.ubuntu%3Aen-US%3Aunofficial%26client%3Dfirefox-a'
	    str = (str+'').toString();

	    // Tilde should be allowed unescaped in future versions of PHP (as reflected below), but if you want to reflect current
	    // PHP behavior, you would need to add ".replace(/~/g, '%7E');" to the following.
	    return encodeURIComponent(str).replace(/!/g, '%21').replace(/'/g, '%27').replace(/\(/g, '%28').
	                                                                    replace(/\)/g, '%29').replace(/\*/g, '%2A').replace(/%20/g, '+');
	},

  /**
   * returns a string imploded form the pieces array and separated with the given glue
   * @author http://kevin.vanzonneveld.net
   * @source http://www.phpjs.org
   */
  implode: function(glue, pieces) {
    // http://kevin.vanzonneveld.net
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // +   improved by: Waldo Malqui Silva
    // +   improved by: Itsacon (http://www.itsacon.net/)
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: implode(' ', ['Kevin', 'van', 'Zonneveld']);
    // *     returns 1: 'Kevin van Zonneveld'
    // *     example 2: implode(' ', {first:'Kevin', last: 'van Zonneveld'});
    // *     returns 2: 'Kevin van Zonneveld'

    var i = '', retVal='', tGlue='';
    if (arguments.length === 1) {
        pieces = glue;
        glue = '';
    }
    if (typeof(pieces) === 'object') {
        if (pieces instanceof Array) {
            return pieces.join(glue);
        }
        else {
            for (i in pieces) {
                retVal += tGlue + pieces[i];
                tGlue = glue;
            }
            return retVal;
        }
    }
    else {
        return pieces;
    }
  },
  
  /**
   * returns number of strings separated by comma OR string
   */
  getCountByCommaNl: function(pString){
    var lString='', lArray = new Array(), lCleaned = new Array();
    // Convert line breaks to commas
    lString = pString.replace(/[\r\n]+/g, ',');
    // Remove all remaining white space
    lString = lString.replace(/\s/, '');
    lArray = lString.split(',');
    
    for (var i in lArray) {
      if(lArray[i]){
        lCleaned.push(lArray[i]);
      }
    }

    return lCleaned.length;
  },
  
  empty: function(element, index, array) {
    return (element != '');
  }
};


/**
 * helper to find e.g. the actual scrollheight
 * @author karina
 */
var PositionHelper = {

  /**
   * returns the actual scrollheight
   * @author KM
   */
  getScrollHeight: function() {
    debug.log("[PositionHelper][getScrollHeight]");
    var lBody = PositionHelper.getBody();
    var lOffset = 0;
    if (window.pageYOffset) {
      lOffset = window.pageYOffset;
    } else if(typeof lBody.scrollTop == "number") {
      lOffset = lBody.scrollTop;
    }
    return lOffset;
  },

  /**
   * returns the right body element (this for crossbrowser-comp)
   * @author KM
   */
  getBody: function() {
    debug.log("[PositionHelper][getBody]");
    var lBody = null;
    if(document.all && !window.opera) {
      lBody =(window.document.compatMode == "CSS1Compat")? window.document.documentElement : window.document.body || null;
    } else {
      lBody = document.documentElement;
    }
    return lBody;
  }
};

var OnLoadGrafic = {

  showGraficByElement: function(pElement, pTop, pLeft) {
    debug.log("[OnLoadGrafic][showGraficByElement]");
    var lPosition = jQuery(pElement).position();
    var pTop = (pTop)?pTop:0;
    var pLeft = (pLeft)?pLeft:0;
    jQuery('#general-ajax-loader').css({
      top:  lPosition.top + pTop,
      left: lPosition.left + pTop
    }).show();
  },
  
  insertGraficToElem: function(pElement, pTop, pLeft) {
    debug.log("[OnLoadGrafic][insertGraficToElem]");
    
    if(pTop === undefined){
      pTop = 0;
    }
    
    if(pLeft === undefined){
      pLeft = 0;
    }    
    
    var lGrafic = jQuery('#general-ajax-loader').clone();
    jQuery(lGrafic).css({
      'margin-top':pTop,
      'margin-left':pLeft
    });
    jQuery(pElement).append(lGrafic);
    jQuery(pElement).children('#general-ajax-loader').show();    
  },
  
  removeGraficFromElem: function(pElement) {
    debug.log("[OnLoadGrafic][removeGraficFromElem]");    
    jQuery(pElement).children('#general-ajax-loader').remove();
  },

  showGraficByWidth: function(pElement) {
    debug.log("[OnLoadGrafic][showGraficByElement]");
    var lPosition = jQuery(pElement).position();
    var pTop = (pTop)?pTop:0;
    var pLeft = (pLeft)?pLeft:0;
    var pWidth = jQuery(pElement).width();
    jQuery('#general-ajax-loader').css({
      top:  lPosition.top + OnLoadGrafic.getPageScroll()[1] + (OnLoadGrafic.getPageHeight() / 4),
      left: lPosition.left + (pWidth/2)
    }).show();
  },

  showGrafic: function() {
    var lTimeout;
    jQuery('#general-ajax-loader').css({
        top:  OnLoadGrafic.getPageScroll()[1] + (OnLoadGrafic.getPageHeight() / 4),
        left: OnLoadGrafic.getPageWidth()/2
      }).show();
    clearTimeout(lTimeout);
    lTimeout = setTimeout(function() {
      OnLoadGrafic.hideGrafic();
    }, 20000);
  },

  hideGrafic: function() {
    jQuery('#general-ajax-loader').hide();
  },

  // getPageScroll() by quirksmode.com
  getPageScroll: function() {
    var xScroll, yScroll;
    if (window.pageYOffset) {
      yScroll = window.pageYOffset;
      xScroll = window.pageXOffset;
    } else if (document.documentElement && document.documentElement.scrollTop) {   // Explorer 6 Strict
      yScroll = document.documentElement.scrollTop;
      xScroll = document.documentElement.scrollLeft;
    } else if (document.body) {// all other Explorers
      yScroll = document.body.scrollTop;
      xScroll = document.body.scrollLeft;
    }
    return new Array(xScroll,yScroll);
  },

  // Adapted from getPageSize() by quirksmode.com
  getPageHeight: function() {
    var windowHeight;
    if (self.innerHeight) { // all except Explorer
      windowHeight = self.innerHeight;
    } else if (document.documentElement && document.documentElement.clientHeight) { // Explorer 6 Strict Mode
      windowHeight = document.documentElement.clientHeight;
    } else if (document.body) { // other Explorers
      windowHeight = document.body.clientHeight;
    }
    return windowHeight;
  },

  getPageWidth: function() {
   if (window.innerWidth) {
      return window.innerWidth;
    } else if (document.body && document.body.offsetWidth) {
      return document.body.offsetWidth;
    } else {
      return 600;
    }
  }
  
  
};
