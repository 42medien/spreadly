var ItemDetail = {

  show: function(pResponse) {
    console.log("[StreamItemDetail][show]");     	
    StreamItem.updateCss(pResponse.css);
    jQuery('#stream_right').empty();
    jQuery('#stream_right').append(pResponse.itemdetail);
  } 	
};

var ItemDetailStream = {
	show: function(pResponse) {
    console.log("[ItemDetailStream][show]");
    if(pResponse.page < 1 || pResponse.page == undefined){
      jQuery('#detail-stream').empty();    	
    }
    jQuery('#item-stream-pager-link').remove();
		jQuery('#detail-stream').append(pResponse.stream);
		var lDataObj = jQuery.parseJSON(pResponse.dataobj);
    DataObjectPager.update('item-stream-pager-link', null, pResponse.page, lDataObj);        
		ItemDetailFilter.updateCss(pResponse.css);
	}
	
};

var ItemDetailFilter = {
  updateCss: function(pCssObj) {
    console.log("[ItemDetailFilter][updateCss]");      	
    var lCssObj = jQuery.parseJSON(pCssObj); 
    var lOuter = jQuery('#nav_shares_outer');
    jQuery(lOuter).removeClass('thumb_all_active');
    jQuery(lOuter).removeClass('thumb_up_active');
    jQuery(lOuter).removeClass('thumb_down_active');   
    jQuery(lOuter).addClass(lCssObj['class']);
  }  
};