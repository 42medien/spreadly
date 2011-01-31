/**
 * @combine Full
 * @combine Like
 */


var json_parse = (function () {

// This is a function that can parse a JSON text, producing a JavaScript
// data structure. It is a simple, recursive descent parser. It does not use
// eval or regular expressions, so it can be used as a model for implementing
// a JSON parser in other languages.

// We are defining the function inside of another function to avoid creating
// global variables.

    var at,     // The index of the current character
        ch,     // The current character
        escapee = {
            '"':  '"',
            '\\': '\\',
            '/':  '/',
            b:    '\b',
            f:    '\f',
            n:    '\n',
            r:    '\r',
            t:    '\t'
        },
        text,

        error = function (m) {

// Call error when something is wrong.

            throw {
                name:    'SyntaxError',
                message: m,
                at:      at,
                text:    text
            };
        },

        next = function (c) {

// If a c parameter is provided, verify that it matches the current character.

            if (c && c !== ch) {
                error("Expected '" + c + "' instead of '" + ch + "'");
            }

// Get the next character. When there are no more characters,
// return the empty string.

            ch = text.charAt(at);
            at += 1;
            return ch;
        },

        number = function () {

// Parse a number value.

            var number,
                string = '';

            if (ch === '-') {
                string = '-';
                next('-');
            }
            while (ch >= '0' && ch <= '9') {
                string += ch;
                next();
            }
            if (ch === '.') {
                string += '.';
                while (next() && ch >= '0' && ch <= '9') {
                    string += ch;
                }
            }
            if (ch === 'e' || ch === 'E') {
                string += ch;
                next();
                if (ch === '-' || ch === '+') {
                    string += ch;
                    next();
                }
                while (ch >= '0' && ch <= '9') {
                    string += ch;
                    next();
                }
            }
            number = +string;
            if (isNaN(number)) {
                error("Bad number");
            } else {
                return number;
            }
        },

        string = function () {

// Parse a string value.

            var hex,
                i,
                string = '',
                uffff;

// When parsing for string values, we must look for " and \ characters.

            if (ch === '"') {
                while (next()) {
                    if (ch === '"') {
                        next();
                        return string;
                    } else if (ch === '\\') {
                        next();
                        if (ch === 'u') {
                            uffff = 0;
                            for (i = 0; i < 4; i += 1) {
                                hex = parseInt(next(), 16);
                                if (!isFinite(hex)) {
                                    break;
                                }
                                uffff = uffff * 16 + hex;
                            }
                            string += String.fromCharCode(uffff);
                        } else if (typeof escapee[ch] === 'string') {
                            string += escapee[ch];
                        } else {
                            break;
                        }
                    } else {
                        string += ch;
                    }
                }
            }
            error("Bad string");
        },

        white = function () {

// Skip whitespace.

            while (ch && ch <= ' ') {
                next();
            }
        },

        word = function () {

// true, false, or null.

            switch (ch) {
            case 't':
                next('t');
                next('r');
                next('u');
                next('e');
                return true;
            case 'f':
                next('f');
                next('a');
                next('l');
                next('s');
                next('e');
                return false;
            case 'n':
                next('n');
                next('u');
                next('l');
                next('l');
                return null;
            }
            error("Unexpected '" + ch + "'");
        },

        value,  // Place holder for the value function.

        array = function () {

// Parse an array value.

            var array = [];

            if (ch === '[') {
                next('[');
                white();
                if (ch === ']') {
                    next(']');
                    return array;   // empty array
                }
                while (ch) {
                    array.push(value());
                    white();
                    if (ch === ']') {
                        next(']');
                        return array;
                    }
                    next(',');
                    white();
                }
            }
            error("Bad array");
        },

        object = function () {

// Parse an object value.

            var key,
                object = {};

            if (ch === '{') {
                next('{');
                white();
                if (ch === '}') {
                    next('}');
                    return object;   // empty object
                }
                while (ch) {
                    key = string();
                    white();
                    next(':');
                    if (Object.hasOwnProperty.call(object, key)) {
                        error('Duplicate key "' + key + '"');
                    }
                    object[key] = value();
                    white();
                    if (ch === '}') {
                        next('}');
                        return object;
                    }
                    next(',');
                    white();
                }
            }
            error("Bad object");
        };

    value = function () {

// Parse a JSON value. It could be an object, an array, a string, a number,
// or a word.

        white();
        switch (ch) {
        case '{':
            return object();
        case '[':
            return array();
        case '"':
            return string();
        case '-':
            return number();
        default:
            return ch >= '0' && ch <= '9' ? number() : word();
        }
    };

// Return the json_parse function. It will have access to all of the above
// functions and variables.

    return function (source, reviver) {
        var result;

        text = source;
        at = 0;
        ch = ' ';
        result = value();
        white();
        if (ch) {
            error("Syntax error");
        }

// If there is a reviver function, we recursively walk the new structure,
// passing each name/value pair to the reviver function for possible
// transformation, starting with a temporary root object that holds the result
// in an empty key. If there is not a reviver function, we simply return the
// result.

        return typeof reviver === 'function' ? (function walk(holder, key) {
            var k, v, value = holder[key];
            if (value && typeof value === 'object') {
                for (k in value) {
                    if (Object.hasOwnProperty.call(value, k)) {
                        v = walk(value, k);
                        if (v !== undefined) {
                            value[k] = v;
                        } else {
                            delete value[k];
                        }
                    }
                }
            }
            return reviver.call(holder, key, value);
        }({'': result}, '')) : result;
    };
}());


/**
 * Class YiidUtils: Helper functions for the yiid-widget
 * @author Karina Mies, http://snipplr.com/view.php?codeview&id=3561
 */
var YiidUtils = {

  /**
   * checks, if the class is set in the given element
   * @author http://snipplr.com/view.php?codeview&id=3561
   */
  hasClass: function(ele, cls) {
    if(ele === null ) {
      return false;
    }
    return ele.className.match(new RegExp('(\\s|^)'+cls+'(\\s|$)'));
  },

  /**
   * adds a class to the given element
   * @author http://snipplr.com/view.php?codeview&id=3561
   */
  addClass: function(ele, cls) {
    if (!YiidUtils.hasClass(ele,cls)) {
      ele.className += " "+cls;
    }
  },

  /**
   * removes a class from a given element
   * @author http://snipplr.com/view.php?codeview&id=3561
   */
  removeClass: function(ele, cls) {
    if (YiidUtils.hasClass(ele,cls)) {
      var reg = new RegExp('(\\s|^)'+cls+'(\\s|$)');
      ele.className=ele.className.replace(reg,' ');
    }
  },

  /**
   * inserts and remove given classes of pElement
   * @author Karina Mies
   */
  toggleClass: function(pElement, pRemove, pInsert) {
    if(YiidUtils.hasClass(pElement, pRemove)) {
      YiidUtils.removeClass(pElement, pRemove);
      YiidUtils.addClass(pElement, pInsert);
    }
  },

  /**
   * returns an array of elements with the matched classes
   * @author extern
   */
  getElementsByClass: function(domNode, searchClass, tagName) {
    if (domNode == null) domNode = document;
      if (tagName == null) tagName = '*';
      var el = new Array();
      var tags = domNode.getElementsByTagName(tagName);
      var tcl = " "+searchClass+" ";
      for(i=0,j=0; i<tags.length; i++) {
        var test = " " + tags[i].className + " ";
        if (test.indexOf(tcl) != -1)
          el[j++] = tags[i];
      }
      return el;
  },

  /**
   * returns the text inside the given element
   * @author Karina Mies
   */
  getInnerText: function(pElement) {
    if(document.all){
      return pElement.innerText;
    } else{
      return pElement.textContent;
    }
  },

  /**
   * sets the given text inside the given element
   * @author Karina Mies
   */
  setInnerText: function(pElement, pText) {
    if(document.all){
      pElement.innerText = pText;
    } else{
      pElement.textContent = pText;
    }
  },

  /**
   * adds the given to a given element
   *
   */
  AddEventListener: function(element, eventType, handler, capture) {
    if (element.addEventListener) {
      element.addEventListener(eventType, handler, capture);
    } else if (element.attachEvent) {
      element.attachEvent("on" + eventType, handler);
    }
  },

  unbindEvent: function(pElement, pEvent) {
    pElement.pEventType = null;
  },


  /**
   * open the settings-popup
   * @author Karina Mies
   * @param pUrl Path to popup-source
   * @param pCase the case, if the user clicked like(0) or dislike(1)
   */
  openPopup: function (pUrl, pCase) {
    if(pCase != undefined) {
      if(pCase == true) {
        YiidRequest.doSendLike();        
      } else {
        YiidRequest.doSendLike(pCase);
      }
    }

    var lQuery = encodeURI('&url='+YiidWidget.aUrl+'&type='+YiidWidget.aType+'&case=1&serv='+YiidServices.encodeSettings()+'&title='+YiidWidget.aTitle+'&description='+YiidWidget.aDescription+'&photo='+YiidWidget.aPhoto+'&clickback='+YiidWidget.aClickback+'&tags='+YiidWidget.aTags);

    var lPopup = window.open(pUrl+lQuery, 'popup', 'width=830,height=700,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150');
    if(lPopup) {
      return true;
    } else {
      return false;
    }
  },
  
  /**
   * sets attribute=value for a given element
   * @author Karina Mies
   */
  setAttr: function(pElement, pAttribute, pValue) {
    lAttr = document.createAttribute(pAttribute);
    lAttr.nodeValue = pValue;
    pElement.setAttributeNode(lAttr);
  },

  /**
   * removes the complete given element
   * @author Karina Mies
   */
  deleteElement: function(pElement) {
    var lParent = pElement.parentNode;
    while(pElement.hasChildNodes()){
      pElement.removeChild(pElement.lastChild);

    }
    lParent.removeChild(pElement);
  },

  emptyElement: function(pElement) {
    while(pElement.hasChildNodes()){
      pElement.removeChild(pElement.lastChild);
    }
  },

  /**
   * creates the xmlhttprequest-object for the right browser
   * @author Karina Mies
   */
  createXMLHttpRequest: function() {
    var lXhttp = null;
    if (window.ActiveXObject) {
      try {
        // IE 6 and higher
        lXhttp = new ActiveXObject("MSXML2.XMLHTTP");
      } catch (e) {
        try {
          // IE 5
          lXhttp = new ActiveXObject("Microsoft.XMLHTTP");
          } catch (e) {
            lXhttp=false;
          }
      }
    } else if (window.XMLHttpRequest) {
      try {
        // Mozilla, Opera, Safari ...
        lXhttp = new XMLHttpRequest();
      } catch (e) {
        lXhttp=false;
      }
    }
    return lXhttp;
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
  }
};

/**
 * handles the servicesettings
 */
YiidServices = {
  //global array with the service-settings
  aSettings: [],
  //global timestamp, set when widget is actualized
  aTimecheck: null,

  /**
   * read the cookie and write it in a class var
   * @author Karina Mies
   */
  initSettings: function() {
    var lCookie = YiidCookie.getCookie(YiidCookie.aCookieName);
    if(lCookie != null) {
      YiidServices.aSettings = json_parse(lCookie);
    }
    var lTimestamp = YiidCookie.getCookie(YiidCookie.aTimecheck);
    if(lTimestamp != null) {
      YiidServices.aTimecheck = lTimestamp;
    }
  },

  /**
   * updates the actual settings for the current button after clicking service-image in slider
   * @author Karina Mies
   */
  updateSettings: function() {
    var lIndex, lHref;
    lHref = this.getAttribute('href');
    lIndex = lHref.match(/[0-9]+/g);

    //parse the json-string in the cookie
    var lObjects = YiidServices.aSettings;
    //what is the current state of the service?
    var lActive = lObjects[lIndex].active;
    //if the clicked service is inactive, set it to active
    if(lActive == 0){
      lObjects[lIndex].active = "1";
    } else {
    //if the clicked service is active, set it to inactive
      lObjects[lIndex].active = "0";
    }

    //update the image (the cssid is always servicename-activestate)
    YiidUtils.setAttr(this, 'id', lObjects[lIndex].name+"_"+lObjects[lIndex].active);
  },

  /**
   * encodes the settings to a string for the request to action
   */
  encodeSettings: function() {
    var lObjects = YiidServices.aSettings;
    var lOis = new Array();
    for(var i=0; i<lObjects.length; i++) {
      if(lObjects[i].active == 1) {
        lOis.push(lObjects[i].oi_id);
      }
    }
    var lString = YiidUtils.implode(',', lOis);
    return lString;
  },

  /**
   * returns the actual timestamp (checked before slidein)
   * @author Karina Mies
   */
  getActualTimestamp: function() {
    var lTimestamp = YiidCookie.getCookie(YiidCookie.aTimecheck);
    if(lTimestamp != null) {
      return lTimestamp;
    }
  }
};

/**
 * handles the behaviour (decoding...) of the service cookie
 * @author Karina Mies
 */
var YiidCookie = {

  aCookieName: "yiidservices",
  aTimecheck: "yiidservices_timecheck",
  aDomain: "",

  /**
   * returns the cookie specified with the YiidCookie.aCookieName variable
   * @author Karina Mies
   */
  getCookie: function(pName){
    //find the right cookie
    var results = document.cookie.match ( '(^|;) ?' + pName + '=([^;]*)(;|$)' );
    //if we found a cookie, return it
    if (results) {
      return (unescape(results[2]));
    } else {
      return null;
    }
  },

  /**
   * checks, if user has a yiidservice cookie
   * @author Karina Mies
   */
  isCookieSet: function() {
    if(YiidCookie.getCookie(YiidCookie.aCookieName) === null){
      return false;
    }
    return true;
  }
};