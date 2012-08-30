var SchemePicker = {
    
    init: function() {
      debug.log('[SchemePicker][init]');      
      SchemePicker.toggleColorPicker();
      SchemePicker.selectColor();
      
    },
    
    toggleColorPicker: function() {
      debug.log('[SchemePicker][toggleColorPicker]');
      jQuery('#selected-color').live('click', function() {
        //jQuery('#color-picker').slideToggle();
        jQuery('#color-picker').animate({width: 'toggle'});
        return false;
      });
    },
    
    selectColor: function() {
      debug.log('[SchemePicker][selectColor]');      
      jQuery('#color-picker li').live('click', function() {
        debug.log('[SchemePicker][selectColor]');            
        var lClass = jQuery(this).attr('class');
        jQuery('#selected-color').removeClass();
        jQuery('#selected-color').addClass(lClass);
        jQuery('#default-button').removeClass();
        jQuery('#default-button').addClass('button');
        jQuery('#default-button').addClass(lClass);
        return false;
      });
    }
    
    
};