<div id="branding" class="clearfix">
  <div id="branding_left" class="left">
  	<?php if($sf_user->isAuthenticated()) { ?>
  		<a id="yiid_logo" href="<?php echo url_for('visit_history/index'); ?>">&nbsp;</a>
  	<?php } else {?>
    	<a id="yiid_logo" href="<?php echo url_for('@configurator'); ?>">&nbsp;</a>
    <?php } ?>
  </div>
  <div id="branding_middle" class="left">
    <span class="headline_text_big"><?php echo __("Add the Yiid it! Social Sharing Button to your site and instantly increase your audience!"); ?></span>

  </div>
  <div id="branding_right" class="left">
    <?php include_component('system', 'language_switch_icons'); ?>
  </div>
</div>