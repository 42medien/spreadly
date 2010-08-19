/**
 * @combine platform
 */

/**
 * handles the behaviour of the details of a social objects (sidebar-right)
 * @author karina
 */
var ItemDetail = {

  /**
   * callback after click on a stream-item. shows all details on the right sidebar
   * @author KM
   * @param object pResponse(JSON)
   */
  show: function(pResponse) {
    debug.log("[StreamItemDetail][show]");
    //delete the old one
    jQuery('#stream_right').empty();
    //check where the user is and set new position for detail-box
    ItemDetail.setPosition();
    //and insert the new one
    jQuery('#stream_right').append(pResponse.itemdetail);
    //update the css of the clicked stream-item (cssid for it is set in the presponse.css-json-obj)
    StreamItem.updateCss(pResponse.css);
    OnLoadGrafic.hideGrafic();
  },
  
  /**
   * set the detail-box on the right position
   * @author KM
   */
  setPosition: function() {
    debug.log("[StreamItemDetail][setPosition]");  
    //find the current scrollheight
    var lOffsetHeight = PositionHelper.getScrollHeight();
    //get the stream-box
    var lStream = jQuery('#stream_right');
    //and find the right-position for it
    if(lOffsetHeight > 160) {
      jQuery(lStream).css('top', lOffsetHeight-120);
    } else {
      jQuery(lStream).css('top', 0); 
    }    
  }
};

/**
 * handles the behaviour of the tab-filters on top of the detail-box
 * @author KM
 */
var ItemDetailFilter = {
  /**
   * updates the css of the tabs
   * @author KM
   * @param object pCssObj(JSON)
   */
  updateCss: function(pCssObj) {
    debug.log("[ItemDetailFilter][updateCss]"); 
    //make a object from the json
    var lCssObj = jQuery.parseJSON(pCssObj);
    //if a class is set in it
    if(pCssObj && pCssObj['class'] != '') {
	    var lOuter = jQuery('#nav_shares_outer');
	    //remove all highlighting of the tabs
	    jQuery(lOuter).removeClass('thumb_all_active');
	    jQuery(lOuter).removeClass('thumb_up_active');
	    jQuery(lOuter).removeClass('thumb_down_active'); 
	    //and set the clicked one to active (which one was clicked is saved in the css-json at clicked data-obj)
	    jQuery(lOuter).addClass(lCssObj['class']);
    }
  }  
};

/**
 * handles the behaviour of the hot/not...stream in the detail-box
 * @author KM
 */
var ItemDetailStream = {
  /**
   * callback for request to show the right detail-stream
   * @author KM
   * @param object pResponse(JSON) 
   */
  show: function(pResponse) {
    debug.log("[ItemDetailStream][show]");
    //clicked pager or tab?
    if(pResponse.page <= 1 || pResponse.page === undefined){
      //if clicked tab: empty the old stream
      jQuery('#detail-stream').empty();     
    }
    //remove the current pager
    jQuery('#item-stream-pager-link').remove();
    //insert the new stream
    jQuery('#detail-stream').append(pResponse.stream);
    //make a object from json-string
    var lDataObj = jQuery.parseJSON(pResponse.dataobj);
    if(pResponse.pDoPaginate == false) {
      jQuery('#item-stream-pager-link').remove();
    } else {
      //update the pager-settings -> with the append isset a new pager, that needs to be initialized
      DataObjectPager.update('item-stream-pager-link', null, pResponse.page, lDataObj); 
    }
    //and update the hightlight of the clicked tab/filter
    ItemDetailFilter.updateCss(pResponse.css);
    OnLoadGrafic.hideGrafic();    
  }
  
};