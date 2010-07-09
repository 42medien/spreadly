/**
 * @combine Full
 */

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
  		YiidRequest.doSendLike(pCase);
  	}
    var lPopup = window.open(pUrl, 'popup', 'width=600,height=620,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150');
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
    YiidUtils.setAttr(this, 'id', lObjects[lIndex].name+"-"+lObjects[lIndex].active);    
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
 * Class YiidSlider: Class to slide boxes horizontal
 * @author Karina Mies
 */
var YiidSlider = {

  //global variables needed in the object-methods
  aClickElement: null,
  aSlideElement: null,
  aOffsetWidth: '',
  aSlidingArea: null,
  aClickSlideInEvent: null,
  
  /**
   * inits the class variables for slider
   */
  init: function() {
    //the box that is hidden and will slide on
    if(YiidSlider.aSlideElement === null) {
      YiidSlider.aSlideElement = document.getElementById('slide-box');
    }
    //the element that inits the slideon/of (arrow)
    if(YiidSlider.aClickElement === null) {
      YiidSlider.aClickElement = document.getElementById('slide-arrow');
    }
    //the hole sliding area: fix for width:1px-problem
    if(YiidSlider.aSlidingArea === null) {
      YiidSlider.aSlidingArea = document.getElementById('sliding-area');
    }    
  },
  
  /**
   * method called by onclick. Decides if slideon or slide of
   * @author Karina Mies
   */
  slide: function(pEvent) {
  	//YiidServices.initSettings();
    //if there is running a slide, stop it
    YiidSlider.stopInterval();
    //if slider is currently closed, init to open it
    if(YiidUtils.hasClass(YiidSlider.aClickElement, 'closed')) {
    	//set the global var, that we know on other place, that the slider is clicked (needed in toggleclickelement)
    	YiidSlider.aClickSlideInEvent = pEvent;
    	//disable the like/dislike button and set it to settings
      YiidButtons.disable();
      
      YiidInfo.disable();
      
      //slide the setting in
      YiidSlider.slideIn();
    }
    //if slider is currently opened, init to close it
    if(YiidUtils.hasClass(YiidSlider.aClickElement, 'opened')) {
    	//set the global var to null, that we know, the slider is closed (needed in toggleclickelement)
    	YiidSlider.aClickSlideInEvent = null;
    	//close the settings slider
      YiidSlider.slideOut();
    }
  },

  /**
   * Opens the slider
   * @author Karina Mies
   */
  slideIn: function() {
    //counter for the width
    var i = 1;
    //if there is currently an interval running: stop it
    YiidSlider.stopInterval();
    
    if(YiidServices.aTimecheck < YiidServices.getActualTimestamp()) {
    	YiidServices.initSettings();
    }
    
    //removes the favicons
    YiidSlider.removeCell();
    //insert table-cols with the favicons
    YiidSlider.insertCell();
    //show the sliding-area
    YiidSlider.aSlidingArea.style.display='block';
    //get the width of all inserted cols(favicon-styles)
    YiidSlider.aOffsetWidth = document.getElementById('slide-table').offsetWidth+22;
    //set interval to slide in
    YiidSlider.aSlideElement.timer = window.setInterval( function() {
       if(i >= YiidSlider.aOffsetWidth) {
         //if the width of the slideelement has the needed length stop interval and toggle the class from closed to opened
         YiidSlider.toggleClickElement();
         YiidSlider.stopInterval();
       } else {
         // while the slide-element has not the needed width, increase it
         YiidSlider.aSlideElement.style.width = i+'px';
         i=i+4;
       }
    }, 10);

    return false;
  },

  /**
   * Close the slider
   * @author Karina Mies
   */
  slideOut: function() {
    //if there is currently an interval running: stop it
    YiidSlider.stopInterval();
    //set interval to slide out
    YiidSlider.aSlideElement.timer = window.setInterval( function() {
      //check, if the width of the inner slide elements is greater than 0
      if(YiidSlider.aOffsetWidth > 0) {
        // while the slide-element is not closed, decrease the width till 0
        YiidSlider.aSlideElement.style.width = YiidSlider.aOffsetWidth+'px';
        YiidSlider.aOffsetWidth = YiidSlider.aOffsetWidth-8;
      } else {
        //if the width of the slideelement has the needed length stop interval and toggle the class from opend to closed
        YiidSlider.toggleClickElement();        
        //set whole sliding-table to display:none (fix for div. browsers, that has problem with width: 0;)
        YiidSlider.aSlidingArea.style.display='none';
        
        YiidButtons.enable();
        //remove the inserted cols with the favicons
        YiidSlider.hideClickElement();
        YiidSlider.stopInterval();
        YiidInfo.enable();
      }
    }, 10);
    return false;
  },

  /**
   * Read the cookie and creates a tabel cell with favicon for every service
   * @author Karina Mies
   */
  insertCell: function() {
    //the row the cells must be inserted
    var lRow = document.getElementById('slide-row');
    //parse the actual service-information
    var lObjects = YiidServices.aSettings;
    //helper variables to insert the cell
    var lCell, lLink;
    
    //foreach service in the cookie we need a new cell in the tablerow
    for(var i=0; i<lObjects.length; i++){
      //create new cell for every service with index i
      lCell = lRow.insertCell(i);
      //create a new link element
      lLink = document.createElement('a');
      //and append it into the new cell
      lCell.appendChild(lLink);
      //set the needed attributs for the link
      YiidUtils.setAttr(lLink, 'href', "#"+i);
      YiidUtils.setAttr(lLink, 'id', lObjects[i].name+"-"+lObjects[i].active);
      YiidUtils.setAttr(lLink, 'class', 'favicon');
      YiidUtils.setAttr(lLink, 'title', lObjects[i].identifier);
      //Bind the click event to the icons      
      lLink.onclick = YiidServices.updateSettings;
      //for every services we get the markup looking like that: <td><a id="twitter-0" class="favicon" onclick="YiidCookie.updateCookie(0);" href="#100"/></a></td>
      var lText = document.createTextNode('\u00A0');
      lLink.appendChild(lText);
    }
  },

  /**
   * Removes the cells with the services from the slider-table (onclick: slideOut)
   * @author Karina Mies
   */
  removeCell: function() {
    //get the row where the cells where inserted
    var lRow = document.getElementById('slide-row');
    //take all columns
    var lChilds = lRow.getElementsByTagName('td');
    var lLength = lChilds.length;
    //�nd remove all childs from the row
    for(var i=0; i<lLength; i++) {
      if(lChilds[0].id !== 'settings-area') {
        lRow.removeChild(lChilds[0]);
      }
    }

    return true;
  },

  /**
   * stops the running interval and set the timer to null
   * @author Karina Mies
   */
  stopInterval: function() {
    clearInterval(YiidSlider.aSlideElement.timer);
    YiidSlider.aSlideElement.timer = null;
  },

  /**
   * shows the open-slider-element
   * @author Karina Mies
   */
  showClickElement: function() {
    YiidSlider.init();  	
    YiidSlider.aClickElement.style.visibility = 'visible';
  },
  
  /**
   * hides the open-slider-element, or display it if slider is opened
   * @author Karina Mies
   */
  hideClickElement: function(pEvent) {
    // do not hide, if slider is opened
  	if(YiidUtils.hasClass(YiidSlider.aClickElement, 'opened') || YiidSlider.aClickSlideInEvent != null) {
      pEvent = null;
  	} else {
  		// hide if slider is closed
      YiidSlider.aClickElement.style.visibility = 'hidden';  		
  	}
  },
  
  /**
   * set the click element from open to close and backwards
   * @author Karina Mies
   */
  toggleClickElement: function() {
    if(YiidUtils.hasClass(YiidSlider.aClickElement, 'closed')) {
      YiidUtils.toggleClass(YiidSlider.aClickElement, 'closed', 'opened');    	
    }	else {
      YiidUtils.toggleClass(YiidSlider.aClickElement, 'opened', 'closed');    	
    }
  }

};

/**
 * Class for Error Handling
 * @author Karina Mies
 */
var YiidError = {
  /**
   * shows the given error-message in the widget
   * @author Karina Mies
   */
  showError: function(pMessage) {
    if(pMessage == undefined) {
      pMessage = "Error: Something went wrong. <span id='err-signup'>Login</span> and retry!";
    }  
    var lAddText = document.getElementById('additional_text_area');
    YiidUtils.emptyElement(lAddText);
    var lBlock = document.createElement('p');
    YiidUtils.setAttr(lBlock, 'id', 'error-msg')
    lBlock.innerHTML = pMessage;
    lAddText.appendChild(lBlock);
  },
  
  /**
   * shows http errors in the widget
   * @author Karina Mies
   */
  showHttpError: function(pXhttp) {
    //var lErrorElem = document.getElementById('errorelem');
    var lInfoElem = document.getElementById('infelem');
    if(pXhttp.statusText == '') {
      pXhttp.statusText = "Error: Something went wrong";
    }      
    lInfoElem.style.display="none";
    //YiidUtils.setInnerText(lErrorElem, 'Error: '+pXhttp.statusText)
    //lErrorElem.style.display="";    
  },
  
  /**
   * if an undefined error is thrown (e.g. in a try catch), catch it and do nothing
   * @author Karina Mies
   */
  undefinedError: function(pError) {
    return true;
  }
};


/**
 * Class YiidWidget: inits the widget functionality
 * @author Karina Mies
 */
var YiidWidget = {
  
  //global variables needed in the object-methods
  aUrl: '',
  aType: '',
  aTitle: '',
  aDescription: '',
  aPhoto: '',
  aPopupPath: null,
  aServiceSettings: new Array(),
    
  /**
   * inits the widget (after loading the widget)
   * @author Karina Mies
   */    
  init: function(pUrl, pType, pTitle, pDescription, pPhoto) {
    YiidWidget.aUrl = pUrl;
    YiidWidget.aType = pType;
    YiidWidget.aTitle = pTitle;
    YiidWidget.aDescription = pDescription;
    YiidWidget.aPhoto = pPhoto;
    YiidServices.initSettings();
  },

  /**
   * sends the like request if possible, if not slideIn settings or open popup
   * @author Karina Mies
   */
  doLike: function(pCase) {
    if(YiidServices.aTimecheck < YiidServices.getActualTimestamp()) {
      YiidServices.initSettings();
    }  	
    var lPossible = YiidWidget.isLikePossible();
    //inits the slider elements if not set
    YiidSlider.init();
    if(YiidUtils.hasClass(YiidSlider.aClickElement, 'closed')) {
      //if user has services and activated one or more services
      if(lPossible === 1) {
        YiidRequest.doSendLike(pCase);
        //update the layout of the button and its content
        YiidWidget.markAsUsed();
        if(pCase == 1) {
          YiidButtons.markLiked();
          YiidInfo.markLiked();
        } else {
          YiidButtons.markDisliked();
          YiidInfo.markDisliked();
        }
      //if user has services but non of them is activated
      } else if(lPossible === 0) {
        YiidSlider.slide();
      //if user has no services, open the settings popup
      } else {
      	YiidRequest.doSendLike(pCase);
        YiidUtils.openPopup(YiidWidget.aPopupPath);
      }
      return false;
    }
  },
  
  /**
   * check if a like is possible. returns 1: if a service is active. returns 0: if no service is active. returns 2: if user has no services
   * @author Karina Mies
   */
  isLikePossible: function() {
    var lCookie = YiidCookie.getCookie(YiidCookie.aCookieName);
    //if user has a service-cookie
    if(lCookie) {
      //parse the cookie
      var lObjects = YiidServices.aSettings;
      //and get the length
      var lObjectLength = lObjects.length;
      //if the length is greater than 0, means that user inserted min. one service
      if(lObjectLength > 0) {
        //check if there is a service activated
        for(var i=0; i<lObjects.length; i++) {
          if(lObjects[i].active == 1) {
            return 1;
          }
        }
        //if there is no service activated
        return 0;
      }
    }
    // if user has no services
    return 2;
  },
  
  /**
   * display the used button and hide the possibility to like again
   * @author Karina Mies
   */
  markAsUsed: function() {
    var lButton = document.getElementById('container');
    lButton.style.display = "none";
    var lUsedButton = document.getElementById('container_used');
    lUsedButton.style.display="block";
  },
  
  /**
   * display the like/dislike buttons to like again
   * @author Karina Mies
   */  
  markAsUnused: function() {
    var lButton = document.getElementById('container_used');
    lButton.style.display = "none";
    var lUnusedButton = document.getElementById('container');
    lUnusedButton.style.display="";   
  }

};

/**
 * class for the additional info in the right of the widget
 * @author Karina Mies
 */
var YiidInfo = {
	
	/**
   * mark the text as as liked (currently only update counter)
   * @author Karina Mies
	 */
	markLiked: function() {
    var lLike = document.getElementById('you-like');
    lLike.style.display = "inline";		
	},
	
  /**
   * mark the text as as disliked (currently only update counter)
   * @author Karina Mies
   */	
	markDisliked: function() {
		var lDislike = document.getElementById('you-dislike');
    lDislike.style.display = "inline"; 		
	},
	
	/**
	 * hides the info-area (e.g. if slider is on)
	 * @author Karina Mies
	 */
	disable: function() {
	 document.getElementById('additional_text_area').style.display="none";	
	},
	
	/**
	 * shows the info-area (e.g. if slider is of)
	 * @author Karina Mies
	 */
	enable: function() {
   document.getElementById('additional_text_area').style.display="block";  
	}
};

/**
 * class for the buttons only
 * @author Karina Mies
 */
var YiidButtons = {
  
  /**
   * disable the like/dislike buttons (eg if slider is opened)
   * @author Karina Mies
   */  
  disable: function() {
    var lButton = document.getElementById('normal_button');
    var lSettings = document.getElementById('settings_button');
    if(lButton && lSettings) {
    	lButton.style.display="none";
      lSettings.style.display="block";    	
    }
  },
  
  /**
   * enable the like/dislike buttons (eg if slider is closed)
   * @author Karina Mies
   */  
  enable: function() {
    var lButton = document.getElementById('normal_button');
    var lSettings = document.getElementById('settings_button');
    if(lButton && lSettings) {
      lSettings.style.display="none";      
      lButton.style.display="block";
    }
  },
  
  /**
   * mark the buttons as liked (currently only update counter)
   * @author Karina Mies
   */
  markLiked: function() {
    var lLikedText = document.getElementById('liked-text');
    lLikedText.style.display="block";
  },
  
  /**
   * mark the buttons as disliked (currently only update counter)
   * @author Karina Mies
   */  
  markDisliked: function() {
    var lDislikedText = document.getElementById('disliked-text');
    lDislikedText.style.display="block";  
  }  
};

/**
 * handles the requests to the action (e.g. after click like/dislike)
 * @author Karina Mies
 */
var YiidRequest = {
  
  //global vars with path to servers
  aDislikeAction: '',
  aLikeAction: '',
  
  /**
   * sends the like with settings to the defined action
   * @author Karina Mies
   */
  doSendLike: function(pCase, pOpenPopup) {
    //create a new xmlhttprequest object
    var lXhttp = YiidUtils.createXMLHttpRequest();
    if(lXhttp != null) {
      try{
        //to which action should we send the request?
        var lAction = YiidRequest.aLikeAction;
        if(pCase === 0) {
          lAction = YiidRequest.aDislikeAction;
        }
        //build the param-string
        var lQuery = encodeURI('url='+YiidWidget.aUrl+'&type='+YiidWidget.aType+'&case='+pCase+'&serv='+YiidServices.encodeSettings()+'&title='+YiidWidget.aTitle+'&description='+YiidWidget.aDescription+'&photo='+YiidWidget.aPhoto);        
        lXhttp.open("POST", lAction, true); 
        //Send the proper header information along with the request
        lXhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        lXhttp.setRequestHeader("Content-length", lQuery.length);
        lXhttp.setRequestHeader("Connection", "close");
        lXhttp.onreadystatechange = function() {
          //if request is complete
          if(lXhttp.readyState == 4) {
            //and something went wrong
            if(lXhttp.status != 200) {
              //show http error
              //YiidError.showHttpError(lXhttp);
            } else {
              //if all went good, check if there are internal errors
              YiidRequest.delegateResponse(lXhttp);
            }
          }
        };
        lXhttp.send(lQuery);          
      } catch(lError) {
        YiidError.undefinedError(lError);
      }
    }
  },
  
  /**
   * Evaluate the response after clicking like/unlike, shows errors and defines the behaviour of the widget
   * @author Karina Mies
   */
  delegateResponse: function(pXhttp) {
    //get the json-response as string
    var lResponse = pXhttp.responseText;
    //parse the string to to object
    var lJson = json_parse(lResponse);
    //if there was an internal error after request
    if(lJson.success === false) {
      //if there was no active session
      if(lJson.status == '401') {
        //show the like/dislike buttons
        YiidWidget.markAsUnused();
        //hide the element to open the slider
        //YiidSlider.hideClickElement();
        //open the login/reg popup
        //YiidUtils.openPopup(YiidWidget.aPopupPath);
        //and show the error in the widget
        YiidError.showError(lJson.message);
      } else {
        //currently we only evaluate the 401->no active session error. all other we handle in the same way
        //YiidError.showHttpError(pXhttp);
      }
    }    
  }
};
