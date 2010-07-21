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
		jQuery('#detail-stream').empty();
		jQuery('#detail-stream').append(pResponse.stream);
		ItemDetailFilter.updateCss(pResponse.css);
	},
	
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