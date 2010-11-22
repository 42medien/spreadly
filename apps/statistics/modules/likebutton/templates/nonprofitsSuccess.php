<?php use_helper('Headline'); ?>

<?php echo __('TESTIMONIAL_NONPROFITS', array('%1' => '', array('title' => '', 'height' => '50px', 'class' => 'left')), 'configurator'); ?>

<div class="description_box_head">
  <?php echo green_headline(__('FOR_NON_PROFITS', null, 'configurator'), 20, 45); ?>
</div>
<div class="dark_bg description_box light_border_bottom_side" id="magazine_desc">
  <p class="important_text"><?php echo __('IF_YOU_WANT_TO', null, 'configurator'); ?></p>
  <ul class="important_text light_border_right_side medium_light_bg">
    <li><?php echo __('INCREASE_BENEFACTORS', null, 'configurator'); ?></li>
	  <li><?php echo __('DO_GOOD_AND_TELL', null, 'configurator'); ?></li>
	  <li><?php echo __('FAN_ACTICLES', null, 'configurator'); ?></li>
	</ul>
	<p class="important_text"><?php echo __('REPLACE_BUTTON_ROWS', null, 'configurator'); ?></p>
</div>

<div class="description_box_head">
  <?php echo grey_headline(__('ADVANTAGES_FOR_NONPROFITS', null, 'configurator'), 30, 60); ?>
</div>
<ul class="content_list description_box">
  <li><?php echo __('ONE_BUTTON_ONE_CLICK', null, 'configurator'); ?></li>
  <li><?php echo __('NO_REDIRECTION', null, 'configurator'); ?></li>
  <li><?php echo __('QUICK_POLLS', null, 'configurator'); ?></li>
  <li><?php echo __('AUTOMATIC_ADDRESS_FORMS', null, 'configurator'); ?></li>
  <li><?php echo __('DETAILED_STATISTICS', null, 'configurator'); ?></li>
  <li><?php echo __('MAILINGS', null, 'configurator'); ?></li>
</ul>


<div id="take_button">
  <span class="button_outer">
    <?php echo link_to(__('GET_YOUR_BUTTON', null, 'configurator'), '@homepage', array('class' => 'button_inner color_light important_text')); ?>
  </span>
</div>
<p class="big_size" id="contact_information"><?php echo __('QUESTIONS', array('%1' => mail_to('info@yiid.com')), 'configurator'); ?></p>