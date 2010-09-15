/**
 * @combine Full
 * @combine Like
 */

var YiidFriends = {
  
  aGetAction: "",
    
  /**
   * inits the show/getFriens-methods
   * @param pObjectId
   * @param pUserId
   * @param pLimit
   */
  init: function(pObjectId, pUserId, pLimit) {
    YiidFriends.getFriends(pObjectId, pUserId, pLimit);
  },
  
  /**
   * send a request to get the share-friends and handle the request
   * @param pObjectId
   * @param pUserId
   * @param pLimit
   */
  getFriends: function(pObjectId, pUserId, pLimit) {
    var lXhttp = YiidUtils.createXMLHttpRequest();
    try{
      var lQuery = encodeURI('so_id='+pObjectId+'&u_id='+pUserId+'&limit='+pLimit);        
      lXhttp.open("POST", YiidFriends.aGetAction, true); 
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
            YiidFriends.handleRequest(lXhttp);
            //console.log(lXhttp);
          }
        }
      };
      lXhttp.send(lQuery);            
      
    }catch(lError) {
      YiidError.undefinedError(lError);      
    }
  },
  
  /**
   * gets the response and delegate it
   * @param pXhttp
   */
  handleRequest: function(pXhttp) {
    //get the json-response as string
    var lResponse = pXhttp.responseText;
    //parse the string to to object
    var lJson = json_parse(lResponse);
    if(lJson.success === true) {
      YiidFriends.showFriends(lJson.html);
    }
  },
  
  /**
   * rekursiv method, to check, if the friends-elem is loade. if so it inserts the html from response
   * @param pHtml
   * @returns boolean
   */
  showFriends: function(pHtml) {
    var lContainer = document.getElementById("friends");
    if(lContainer !== undefined) { 
      lContainer.innerHTML = pHtml;
    } else {
      YiidFriends.showFriends(pHtml);
    } 
    return true;
  }
};