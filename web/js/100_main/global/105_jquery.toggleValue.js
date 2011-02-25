/**
 * @combine platform
 * @combine statistics
 * @combine widget
 */
jQuery.fn.toggleValue = function(){
  var lText = jQuery(this).val();
  console.log(lText);
  var lNewText = '';
  jQuery(this).bind('click', function() {
    console.log(this);
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