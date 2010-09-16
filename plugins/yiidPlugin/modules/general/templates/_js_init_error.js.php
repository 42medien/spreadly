<?php echo "\n"; ?>

<?php if ($sf_user->hasFlash("error")) { ?>
jQuery('#error-msg-box').topslider({
  "msg": '["<?php echo $sf_user->getFlash("error"); ?>"]',
  "speed": 500,
  "timeout": 5000
});
<?php } ?>