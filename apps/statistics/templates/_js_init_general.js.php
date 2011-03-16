ErrorHandler.catchGlobalError();
//jQuery('a[rel*=facebox]').facebox();
jQuery('.colorbox').colorbox({
		opacity: '0.8'
});

jQuery('#mycarousel').jcarousel({
  wrap: 'circular',
  initCallback: mycarousel_initCallback
});