/**
 * @nocombine statistics
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

/*
jQuery.fn.mirrorChangeValue = function(){
  return this.each(function(){
    var lCurrentText, lNewText, lId, lMirrorId, lMirrorText;
    debug.log(this.id);
    jQuery(this).change(function(e) {
      lId = '#'+jQuery(this).attr('id');
      lMirrorId = lId+'-mirror';
      lCurrentText = jQuery(lId).val();
      debug.log('lCurrentText '+lCurrentText);
      jQuery(lMirrorId).text(lCurrentText);
    });
    jQuery(this).trigger('change');
  });
};*/