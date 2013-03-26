jQuery(document).ready(function() {
  jQuery('input:text').labelify({labelledClass: "labelinside-dark"}).focus().blur();
  jQuery('textarea').labelify({labelledClass: "labelinside-light"}).focus().blur();

  jQuery('.tooltip').hover(
    function () {
      jQuery(this).append(jQuery('<div class="triangle-down-ie"></div>'));
    },
    function () {
      jQuery(this).find('.triangle-down-ie').remove();
    }
  );

  jQuery('.bg_checkbox input').live('change', function(){
    var ref = jQuery(this);
    var wrapper = ref.parent();
    if(ref.is(':checked')) wrapper.addClass('checked');
    else wrapper.removeClass('checked');
  });
  jQuery('.bg_checkbox input').trigger('change');    
});
