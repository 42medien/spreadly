<?php use_helper('Headline'); ?>

<div class="small_box_head">
  <?php echo grey_headline(__('PLUGINS_BLOGS', null, 'configurator'), 0, 50); ?>
</div>
<ul class="content_list small_box">
  <li><?php echo link_to(__('PLUGIN_WORDPRESS', null, 'configurator'), 'http://wordpress.org/extend/plugins/yiidit/', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Magento', 'http://www.magentocommerce.com/magento-connect/Watercooling/extension/4063/ekaabo_yiid_it_button', array('target' => '_blank')); ?></li>
  <li><?php echo link_to('Typo3', 'http://typo3.org/extensions/repository/view/yiid_like/current/', array('target' => '_blank')); ?></li>
  <li><?php echo __('Drupal', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('MediaWiki', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('MovableType', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('TextPattern', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
  <li><?php echo __('Joomla', null, 'configurator'); ?> <?php echo __('COMING_SOON', null, 'configurator'); ?></li>
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
  <?php echo grey_headline(__('API', null, 'configurator'), 30, 20); ?>
</div>
<p class="content_list small_box big_size"><?php echo __('API_EXPLANATION', null, 'configurator'); ?></p>

<p class="big_size" id="contact_information_small"><?php echo __('QUESTIONS', array('%1' => mail_to('info@ekaabo.de')), 'configurator'); ?></p>