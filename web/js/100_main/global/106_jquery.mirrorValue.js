/**
 * @combine statistics
 */
jQuery.fn.mirrorValue = function(){
  return this.each(function(){
    var lCurrentText, lNewText, lId, lMirrorId, lMirrorText, lClass; 
    jQuery(this).keyup(function(e) {
      lId = '#'+jQuery(this).attr('id');
      lMirrorClass = '.'+jQuery(this).attr('id')+'-mirror';
      lCurrentText = jQuery(lId).val();
      jQuery(lMirrorClass).text(lCurrentText);
    });
  });
};