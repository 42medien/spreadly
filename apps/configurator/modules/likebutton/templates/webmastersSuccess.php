<?php use_helper('Headline'); ?>

<div class="small_box_head">
  <?php echo grey_headline(__('PLUGINS_BLOGS', null, 'configurator'), 0, 50); ?>
</div>
<ul class="content_list small_box">
  <li><?php echo link_to(__('PLUGIN_WORDPRESS', null, 'configurator'), 'http://wordpress.org/extend/plugins/yiidit/', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Magento', 'http://www.magentocommerce.com/magento-connect/Watercooling/extension/4063/ekaabo_yiid_it_button', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Typo3', 'http://typo3.org/extensions/repository/view/yiid_like/current/', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Drupal', 'http://drupal.org/project/yiid', array('target' => '_blank')); ?></li>
  <li><?php echo __('MediaWiki', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('MovableType', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo link_to('TextPattern', 'http://yiid.googlecode.com/svn/textpattern/tags/1.0/yiid_like.txt', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Joomla', 'http://code.google.com/p/yiid/downloads/list?q=label:joomla', array('target' => '_blank')); ?></li>
</ul>

<div class="small_box_head">
  <?php echo grey_headline(__('SETUP_INSTRUCTIONS', null, 'configurator'), 30, 79); ?>
</div>
<ul class="content_list small_box">
  <li><?php echo link_to(__('Blogger.com', null, 'configurator'), 'http://yiidit.blogspot.com/', array('target' => '_blank')); ?></li>
  <li><?php echo link_to(__('Posterous.com', null, 'configurator'), 'http://yiidit.posterous.com/', array('target' => '_blank')); ?></li>
  <li><?php echo link_to(__('Tumblr.com', null, 'configurator'), 'http://yiidit.tumblr.com/', array('target' => '_blank')); ?></li>
  <li><?php echo __('BBCode für phpBB und vBulletin', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('Antville', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
</ul>

<div class="small_box_head">
  <?php echo grey_headline(__('Static button'), 30, 40); ?>
</div>
<div class="content_list small_box big_size clearfix">
	<p><?php echo __("For newsletter and websites that don't support the implementation of iframes, Yiid offers a static button with limited functionality."); ?></p>
	<p><?php echo __('Please copy the following code and insert your individual parameter settings. The static button supports all standard parameters despite "short", "social", "photo" und "color".'); ?></p>
	<div class="clearfix" id="conf-static-button">
		<textarea id="static_button_code_img" class="left"><a href="<?php echo sfConfig::get('app_settings_widgets_url'); ?>/static/like?url=YOURURL" target="_blank"><img src="<?php echo sfConfig::get('app_settings_url').'img/global/yiid-btn-full-'.$sf_user->getCulture(); ?>" alt="Like" /></a></textarea>
		<a href="<?php echo sfConfig::get('app_settings_widgets_url'); ?>/static/like?url=http://www.yiid.com" target="_blank"><?php echo image_tag('/img/global/yiid-btn-full-'.$sf_user->getCulture()); ?></a>
	</div>
	<p><?php echo __("If you prefer to use Yiid without any graphics, you can insert your own text as shown here:"); ?></p>

	<textarea id="static_button_code"><a href="<?php echo sfConfig::get('app_settings_widgets_url'); ?>/static/like?url=YOURURL" target="_blank"><?php echo __('Your Like text'); ?></a></textarea>
</div>

<p class="big_size" id="contact_information_small"><?php echo __('QUESTIONS', array('%1' => mail_to('info@yiid.com')), 'configurator'); ?></p>