jQuery.fn.charcounter = function(){
  //pLimit = parseInt(pLimit, 10);
  var lText = jQuery(this).val();
  var lLenght = lText.length;
  var lThis = this;
  var lTimeout;  
  var lCounterElement = jQuery('#'+jQuery(this).attr('id')+'_counter');
  lText = jQuery(lThis).val();
  jQuery(lCounterElement).html(lText.length);    
  
  //set onfocus state of counter value
  jQuery(this).focus(function() {
    clearTimeout(lTimeout);
    lTimeout = setTimeout(function() {
      lText = jQuery(lThis).val();
      jQuery(lCounterElement).html(lText.length);  
    }, 100);
  });      

  //set blur state of counter value
  jQuery(this).blur(function(){
    clearTimeout(lTimeout);
    lText = jQuery(this).val();
    jQuery(lCounterElement).html(lText.length);
  });  
  
  //set keyup state of counter value
  jQuery(this).keyup(function(){
    lText = jQuery(this).val();
    var lLength = lText.length; 
    lText = jQuery(this).val();
    jQuery(lCounterElement).html(lText.length); 
  });
};