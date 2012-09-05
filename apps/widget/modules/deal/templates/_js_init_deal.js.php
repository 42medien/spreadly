WidgetLikeForm.send();
CouponCode.initClipboard("<?php echo sfConfig::get('app_settings_url'); ?>/flash/ZeroClipboard.swf");

LikeIdentity.init();

ProfileSettings.init();

$(document).ready(function() {
  $('.likecheckbox').change(function(){  
    if($(this).is(":checked")){  
      $(this).next("label").addClass("checked");  
    } else {  
      $(this).next("label").removeClass("checked");  
    }  
  });  
});  