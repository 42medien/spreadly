ErrorHandler.catchGlobalError();
jQuery('.colorbox' ).live('click',function(e){
	e.preventDefault();
  jQuery(this).colorbox({open:true});
});


jQuery('#mycarousel').jcarousel({
  wrap: 'circular',
  initCallback: mycarousel_initCallback
});