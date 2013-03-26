jQuery(document).ready(function(){
  jQuery(".tagbtn").click(function() {
    jQuery(this).closest('li').remove();
  });

  jQuery("#key_enter").keypress(function(event) {
    if (event.which == 44){
      event.preventDefault();
      var text = jQuery(this).val();
      jQuery(this).val("");
      jQuery(this).closest('li').before('<li><div class="tagcont">' +
        '<div class="tagtxt">'+text+'</div>' +
        '<input type="hidden" name="tags[]" value="'+text+'" />' +
        '</div></li>');
      jQuery(".tagtxt").click(function() {
        jQuery(this).closest('li').remove();
      });
      jQuery(this).val("");
    }
  });

  jQuery('#texarea_count').bind('keyup', function(){
    var characterLimit = 140;
    var charactersUsed = jQuery(this).val().length;
    if (charactersUsed >= 140) {
      //$(this).val($(this).val().substr(0, characterLimit));
      jQuery('#chars_counter').addClass('count-exceeded').html(charactersUsed)
    }else {
      jQuery('#chars_counter').removeClass('count-exceeded').text(charactersUsed);
    }

  });
    
  jQuery('.add_tags').click(function(){
    jQuery('#key_enter').focus();
  }).find('.tagcont').click(function(e) {
    return false;
  });
  ;
});