/**
 * @combine platform
 * @combine statistics
 */
jQuery.fn.toggleValue = function(){
  var lText = jQuery(this).val();
  var lNewText = '';
  jQuery(this).bind('click', function() {
    lNewText = jQuery(this).val();
    if(lNewText == lText){
      jQuery(this).val('');
    }
  });

  jQuery(this).blur(function(){
    lNewText = jQuery(this).val();
    if(lNewText == '') {
      jQuery(this).val(lText);
    }
  });
};