var ItemDetail = {

  show: function(pResponse) {
    console.log("[StreamItemDetail][show]");     	
    jQuery('#stream_right').empty();
    jQuery('#stream_right').append(pResponse.itemdetail);
    StreamItem.updateCss(pResponse.css);
  } 	
}