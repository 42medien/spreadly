<?php use_helper('Text'); ?>
<?php include_component('profile', 'profile_info'); ?>
<div class="wht-contentbox clearfix">
	<div class="whtboxpad clearfix">
    <dl class="profilelink friendactbox alignleft">
    	<dt><?php echo __('Friends Lastest Activities'); ?></dt>
    	<?php if(count($pLatestActivities) > 0) { ?>
			<?php foreach ($pLatestActivities as $lActivity) { ?>
      		<dd><a href="<?php echo $lActivity->getUrl(); ?>"><?php echo truncate_text($lActivity->getTitle(), 100, '...'); ?></a></dd>
      <?php } ?>

    	<?php } else { ?>
			<!-- dd><?php //echo __('Your friends have no likes at the moment'); ?></dd -->

    	<?php } ?>
      <dd><a href="#">For sale: The House From Ferris Bueller</a></dd>
      <dd><a href="#">The Future Of Selling: It is Social</a></dd>
      <dd class="last"><a href="#">Why Your Next Car Will Have an IP Adress</a></dd>
    </dl>
  </div>
</div>
<div class="whtboxbot"><span></span></div>