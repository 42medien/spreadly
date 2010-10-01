<div id="desc_left">
  <p class="important-text"><?php echo __('YIID_IT_DESCRIPTION_1', null, 'configurator'); ?></p>
  
  <p class="list_headline important_text" id="navigation_benefits"><?php echo __("What's the benefits for me"); ?></p>
  <ul id="benefits" class="normal_list">
    <li class="important_text"><?php echo link_to(__(".. in general?"), '/', array('class' => 'toggle-benefits', 'id' => 'general_area')); ?></li>
    <li class="important_text"><?php echo link_to(__(".. as a publisher?"), '/', array('class' => 'toggle-benefits', 'id' => 'publishers_area')); ?></li>
    <li class="important_text"><?php echo link_to(__(".. as a merchant?"), '/', array('class' => 'toggle-benefits', 'id' => 'merchant_area')); ?></li>
    <li class="important_text"><?php echo link_to(__(".. as a non-profit organization?"), '/', array('class' => 'toggle-benefits', 'id' => 'nonprofits_area')); ?></li>
  </ul>
</div>

<div id="desc_right">
  <p class="important-text"><?php echo __('YIID_IT_DESCRIPTION_2', null, 'configurator'); ?></p>
  <?php echo cdn_image_tag('img/global/yiid_button_spread_wo_buzz.png', array('alt' => 'yiid', 'id' => 'spread_image')); ?>
</div>


<div id="benefits_general_area" class="benefits clearfix">
  <div class="left half" id="benefits_general_left">
	  <?php echo grey_headline(__('BENEFITS_OWNERS_HEADLINE', null, 'configurator'), 30, 80); ?>
		<ul class="content_list">
		  <?php echo __('BENEFITS_OWNERS_LIST', null, 'configurator'); ?>
		</ul>
	</div>
	
	<div class="left half">
		<?php echo grey_headline(__('BENEFITS_VISITORS_HEADLINE', null, 'configurator'), 30, 80); ?>
		<ul class="content_list">
		  <?php echo __('BENEFITS_VISITORS_LIST', null, 'configurator'); ?>
		</ul>
	</div>
</div>


<div id="benefits_publishers_area" class="benefits clearfix">
  <div class="left half" id="benefits_publishers_left">
		<?php echo green_headline(__('FOR_MAGS_AND_BLOGS', null, 'configurator'), 30, 70); ?>
		<div class="dark_bg description_box light_border_bottom_side" id="magazine_desc">
		  <p class="important_text"><?php echo __('IF_YOU_WANT_TO', null, 'configurator'); ?></p>
		  <ul class="important_text light_border_right_side medium_light_bg">
		    <li><?php echo __('INCREASE_MEDIA_PENETRATION', null, 'configurator'); ?></li>
		    <li><?php echo __('SOCIAL_RECOMMENDATION', null, 'configurator'); ?></li>
		    <li><?php echo __('SUBSCRIBERS', null, 'configurator'); ?></li>
		  </ul>
		  <p class="important_text"><?php echo __('REPLACE_BUTTON_ROWS', null, 'configurator'); ?></p>
		</div>
  </div>
	
	<div class="left half">
		<div class="description_box_head">
		  <?php echo grey_headline(__('ADVANTAGES_FOR_PUBLISHERS', null, 'configurator'), 30, 70); ?>
		</div>
		<ul class="content_list description_box">
		  <li><?php echo __('ONE_BUTTON_ONE_CLICK', null, 'configurator'); ?></li>
		  <li><?php echo __('APPROPRIATE_WORDINGS', null, 'configurator'); ?></li>
		  <li><?php echo __('NO_REDIRECTION', null, 'configurator'); ?></li>
		  <li><?php echo __('POSITIVE_NEGATIVE_RATINGS', null, 'configurator'); ?></li>
		  <li><?php echo __('DETAILED_STATISTICS', null, 'configurator'); ?></li>
		  <li><?php echo __('MAILINGS', null, 'configurator'); ?></li>
		</ul>
	</div>
</div>


<div id="benefits_merchant_area" class="benefits clearfix">
  <div class="left half" id="benefits_merchant_left">
    <?php echo green_headline(__('FOR_SHOPS', null, 'configurator'), 30, 70); ?>
    <div class="dark_bg description_box light_border_bottom_side" id="magazine_desc">
      <p class="important_text"><?php echo __('IF_YOU_WANT_TO', null, 'configurator'); ?></p>
      <ul class="important_text light_border_right_side medium_light_bg">
        <li><?php echo __('REACH_CUSTOMERS_FRIENDS', null, 'configurator'); ?></li>
        <li><?php echo __('GET_RECOMMENDATIONS', null, 'configurator'); ?></li>
        <li><?php echo __('DISTRIBUTE_SAMPLES', null, 'configurator'); ?></li>
      </ul>
      <p class="important_text"><?php echo __('REPLACE_BUTTON_ROWS', null, 'configurator'); ?></p>
    </div>
  </div>
  
  <div class="left half">
    <div class="description_box_head">
      <?php echo grey_headline(__('ADVANTAGES_FOR_SHOPS', null, 'configurator'), 30, 70); ?>
    </div>
    <ul class="content_list description_box">
      <li><?php echo __('ONE_BUTTON_ONE_CLICK', null, 'configurator'); ?></li>
      <li><?php echo __('NO_REDIRECTION', null, 'configurator'); ?></li>
      <li><?php echo __('INCENTIVES', null, 'configurator'); ?></li>
      <li><?php echo __('DETAILED_STATISTICS', null, 'configurator'); ?></li>
      <li><?php echo __('MAILINGS', null, 'configurator'); ?></li>
    </ul>
  </div>
</div>


<div id="benefits_nonprofits_area" class="benefits clearfix">
  <div class="left half" id="benefits_nonprofits_left">
    <?php echo green_headline(__('FOR_NON_PROFITS', null, 'configurator'), 30, 70); ?>
    <div class="dark_bg description_box light_border_bottom_side" id="magazine_desc">
      <p class="important_text"><?php echo __('IF_YOU_WANT_TO', null, 'configurator'); ?></p>
      <ul class="important_text light_border_right_side medium_light_bg">
        <li><?php echo __('INCREASE_BENEFACTORS', null, 'configurator'); ?></li>
        <li><?php echo __('DO_GOOD_AND_TELL', null, 'configurator'); ?></li>
        <li><?php echo __('FAN_ACTICLES', null, 'configurator'); ?></li>
      </ul>
      <p class="important_text"><?php echo __('REPLACE_BUTTON_ROWS', null, 'configurator'); ?></p>
    </div>
  </div>
  
  <div class="left half">
    <div class="description_box_head">
      <?php echo grey_headline(__('ADVANTAGES_FOR_NONPROFITS', null, 'configurator'), 30, 80); ?>
    </div>
    <ul class="content_list description_box">
      <li><?php echo __('ONE_BUTTON_ONE_CLICK', null, 'configurator'); ?></li>
      <li><?php echo __('NO_REDIRECTION', null, 'configurator'); ?></li>
      <li><?php echo __('QUICK_POLLS', null, 'configurator'); ?></li>
      <li><?php echo __('AUTOMATIC_ADDRESS_FORMS', null, 'configurator'); ?></li>
      <li><?php echo __('DETAILED_STATISTICS', null, 'configurator'); ?></li>
      <li><?php echo __('MAILINGS', null, 'configurator'); ?></li>
    </ul>
  </div>
</div>