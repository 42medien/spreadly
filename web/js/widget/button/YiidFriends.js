/**
 * @combine button
 */

var YiidFriends = {
  
  aGetAction: "",
    
  /**
   * inits the show/getFriens-methods
   * @param pObjectId
   * @param pUserId
   * @param pLimit
   */
  init: function(pObjectId, pUserId) {
    YiidFriends.getFriends(pObjectId, pUserId);
  },
  
  /**
   * send a request to get the share-friends and handle the request
   * @param pObjectId
   * @param pUserId
   * @param pLimit
   */
  getFriends: function(pObjectId, pUserId) {
    var lXhttp = YiidUtils.createXMLHttpRequest();
    try{
      var lQuery = encodeURI('so_id='+pObjectId+'&u_id='+pUserId);        
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
      //console.log(lError);
      //YiidError.undefinedError(lError);      
    }
  },
  
  /**
   * gets the response and delegate it
   * @param pXhttp
   */
  handleRequest: function(pXhttp) {
    YiidFriends.showFriends(pXhttp.responseText);
  },
  
  /**
   * recursiv method, to check, if the friends-elem is loade. if so it inserts the html from response
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