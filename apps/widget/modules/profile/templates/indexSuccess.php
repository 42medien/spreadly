<?php use_helper('Text'); ?>
<?php include_component('profile', 'profile_info'); ?>
<div class="wht-contentbox clearfix">
	<div class="whtboxpad clearfix">
  	<dl class="profilelink trendingbox alignright">
    	<dt><?php echo __('Trending Topics'); ?></dt>
    	<?php if(count($pHottestObjects) > 0) { ?>
	    	<?php foreach ($pHottestObjects as $lObject) { ?>
		    	<dd class="clearfix"><span class="likethumb alignright"><?php echo $lObject->getLikeCount(); ?></span><a href="<?php echo $lObject->getUrl(); ?>"><?php echo truncate_text($lObject->getTitle(), 100, '...'); ?></a></dd>
		   	<?php } ?>
		  <?php } else { ?>
				<!-- dd><?php //echo __('No hot topics at the moment'); ?></dd -->
		  <?php } ?>
	      <dd class="clearfix"><span class="likethumb alignright">23</span><a href="#">Facebook will end on March 15th!</a></dd>
	      <dd class="clearfix"><span class="likethumb alignright">18</span><a href="#">The Future Of Selling: It is Social</a></dd>
	      <dd class="clearfix last"><span class="likethumb alignright">17</span><a href="#">Working at Facebook: A Day with the Profile Team</a></dd>
    </dl>
    <dl class="profilelink friendactbox alignleft">
    	<dt><?php echo __('Friends Lastest Activities'); ?></dt>
    	<?php if(count($pLatestActivities) > 0) { ?>
			<?php foreach ($pLatestActivities as $lActivity) { ?>
			  <?php $lObject = SocialObjectTable::retrieveByAliasUrl($lActivity->getUrl()); ?>
			  <?php if ($lObject) { ?>
      		<dd><a href="<?php echo $lActivity->getUrl(); ?>"><?php echo truncate_text($lObject->getTitle(), 100, '...'); ?></a></dd>
      	<?php } ?>
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