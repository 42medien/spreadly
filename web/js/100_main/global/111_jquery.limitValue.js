/**
 * @combine platform
 * @combine statistics
 */
jQuery.fn.limitValue = function(pLimit, pElement){
  pLimit = parseInt(pLimit, 10);
  var lText = jQuery(this).val();
  var lThis = this;
  var lTimeout;  
  var lInitLength;
  
  lText = jQuery(this).val();
  //set Initial state of counter-value
  if(lText == '' || lText == undefined) {
    lInitLength = 0;
  } else {
    lInitLength = lText.length;
  }
  jQuery(pElement).html(pLimit-parseInt(lInitLength, 10));    
  
  //set onfocus state of counter value
  jQuery(this).focus(function() {
    clearTimeout(lTimeout);
    lTimeout = setTimeout(function() {
      lText = jQuery(lThis).val();
      jQuery(pElement).html(pLimit-lText.length);  
    }, 100);
  });      

  //set blur state of counter value
  jQuery(this).blur(function(){
    clearTimeout(lTimeout);
    lText = jQuery(this).val();
    jQuery(pElement).html(pLimit-lText.length);
  });  
  
  //set keyup state of counter value
  jQuery(this).keyup(function(){
    lText = jQuery(this).val();
    var lLength = lText.length; 
    if(lLength > pLimit){
      jQuery(this).val(jQuery(this).val().substring(0, pLimit));
    }
    if(jQuery(pElement).html() != pLimit-lLength){
      jQuery(pElement).html((pLimit-lLength <= 0 )?'0':pLimit-lLength);
    }    
  });
};