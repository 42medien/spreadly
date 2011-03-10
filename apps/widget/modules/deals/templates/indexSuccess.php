<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title"><?php echo __('Recent Deals'); ?></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
	<?php if(count($pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser) > 0) { ?>
		<div class="popwidecol alignright" id="coupon-used-box">
			<?php include_component('deals', 'coupon_used', array('pActivityId' => $pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser[0]->getId())); ?>

	  </div>

		<div class="alignleft picnavbox">
	  	<ul class="prnav" id="show-deal-list">
	  		<?php $i = 0; ?>
	  		<?php foreach($pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser as $lActivity) { ?>
		  		<?php $lUrl = $lActivity->getDeal()->getDomainProfile()->getUrl(); ?>
		     	<li><a href="<?php echo url_for('@get_coupon_used?activityid='.$lActivity->getId()); ?>" class="<?php echo ($i == 0)? "active": ""; ?> show-deal-link"><?php echo $lUrl; ?></a></li>
	    		<?php $i++; ?>
	  		<?php } ?>
	    </ul>
	  </div>
	<?php } else { ?>
		<div class="whtboxpad">
			<?php echo __('No deals!'); ?>
		</div>
	<?php } ?>
</div>
<div class="whtboxbot"><span></span></div>