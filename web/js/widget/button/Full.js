/**
 * @combine Full
 */

/**
 * Class YiidSlider: Class to slide boxes horizontal
 * @author Karina Mies
 */
var YiidSlider = {

  //global variables needed in the object-methods
  aClickElement: null,
  aClickElementToOpen: null,
  aClickElementToClose: null,
  aTextAreaElement: null,
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
    // the element that inits the slideon
    if(YiidSlider.aClickElementToOpen === null) {
    	YiidSlider.aClickElementToOpen = document.getElementById('open_settings_icon_area');
    }
    // the element that inits the slideof
    if(YiidSlider.aClickElementToClose === null) {
      YiidSlider.aClickElementToClose = document.getElementById('slide_arrow_opened');
    }
    //the hole sliding area: fix for width:1px-problem
    if(YiidSlider.aSlidingArea === null) {
      YiidSlider.aSlidingArea = document.getElementById('sliding_area');
    }
    //the hole sliding area: fix for width:1px-problem
    if(YiidSlider.aTextAreaElement === null) {
      YiidSlider.aTextAreaElement = document.getElementById('additional_text_area');
    }
  },

  /**
   * Opens the slider
   * @author Karina Mies
   */
  slideIn: function(pEvent) {
  	//set the global var, that we know on other place, that the slider is clicked (needed in toggleclickelement)
  	YiidSlider.aClickSlideInEvent = pEvent;

  	//disable the like/dislike button and set it to settings
    YiidButtons.disable();

    YiidInfo.disable();

    //counter for the width
    var i = 1;
    //if there is currently an interval running: stop it
    YiidSlider.stopInterval();

    //show close icon
    YiidSlider.aClickElementToClose.style.display = 'block';

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
    YiidSlider.aOffsetWidth = document.getElementById('slide_table').offsetWidth+14;
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
  	//set the global var to null, that we know, the slider is closed (needed in toggleclickelement)
  	YiidSlider.aClickSlideInEvent = null;
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
      YiidUtils.setAttr(lLink, 'id', lObjects[i].name+"_"+lObjects[i].active);
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
    //and remove all childs from the row
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
    YiidUtils.toggleClass(YiidSlider.aTextAreaElement, 'big_space_to_left', 'small_space_to_left');
    YiidSlider.aClickElementToOpen.style.display = 'block';
  },

  /**
   * hides the open-slider-element, or display it if slider is opened
   * @author Karina Mies
   */
  hideClickElement: function(pEvent) {
    // do not hide, if slider is opened
  	if(YiidSlider.aClickSlideInEvent != null) {
      pEvent = null;
  	} else {
  		// hide if slider is closed
      YiidUtils.toggleClass(YiidSlider.aTextAreaElement, 'small_space_to_left', 'big_space_to_left');
      YiidSlider.aClickElementToOpen.style.display = 'none';
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
    YiidUtils.setAttr(lBlock, 'id', 'error-msg');
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
  aClickback: '',
  aTags: '',
  aPopupPath: null,
  aServiceSettings: new Array(),

  /**
   * inits the widget (after loading the widget)
   * @author Karina Mies
   */
  init: function(pUrl, pType, pTitle, pDescription, pPhoto, pClickback, pTags) {
    YiidWidget.aUrl = pUrl;
    YiidWidget.aType = pType;
    YiidWidget.aTitle = pTitle;
    YiidWidget.aDescription = pDescription;
    YiidWidget.aPhoto = pPhoto;
    YiidWidget.aClickback = pClickback;
    YiidWidget.aTags = pTags;
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
      YiidSlider.slideIn();
    //if user has no services, open the settings popup
    } else {
    	YiidRequest.doSendLike(pCase);
      YiidUtils.openPopup(YiidWidget.aPopupPath);
    }
    return false;
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
    var lButton = document.getElementById('container_full');
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
    var lUnusedButton = document.getElementById('container_full');
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
        var lQuery = encodeURI('url='+YiidWidget.aUrl+'&type='+YiidWidget.aType+'&serv='+YiidServices.encodeSettings()+'&title='+YiidWidget.aTitle+'&description='+YiidWidget.aDescription+'&photo='+YiidWidget.aPhoto+'&clickback='+YiidWidget.aClickback+'&tags='+YiidWidget.aTags);
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