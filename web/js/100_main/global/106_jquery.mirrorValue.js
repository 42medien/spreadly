/**
 * @nocombine statistics
 * @author Karina Mies
 * @description Mirrors the input of an textfield, identified by id
 */
jQuery.fn.mirrorValue = function(){
  return this.each(function(){
    var lCurrentText, lId, lMirrorClass; 
    jQuery(this).keyup(function(e) {
      lId = '#'+jQuery(this).attr('id');
      lMirrorClass = '.'+jQuery(this).attr('id')+'-mirror';
      lCurrentText = jQuery(lId).val();
      jQuery(lMirrorClass).text(lCurrentText);
    });
  });
};