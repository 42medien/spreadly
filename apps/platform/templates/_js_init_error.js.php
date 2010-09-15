jQuery('#error-msg-box').topslider({
  "msg": '<?php echo $sf_data->getRaw("pErrors"); ?>',
  "speed": 500,
  "timeout": 5000
});
