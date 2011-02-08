<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title"><?php echo __('Recent Deals'); ?> <em><?php echo __('(Coupons that have run out, are deleted from this list automatically)'); ?></em></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
	<?php if(count($pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser) > 0) { ?>
		<div class="popwidecol alignright" id="coupon-used-box">
			<?php include_component('deals', 'coupon_used', array('pDealId' => '1')); ?>

	  </div>

		<div class="alignleft picnavbox">
	  	<ul class="prnav" id="show-deal-list">
	  		<?php foreach($pActiveFormerlyKnownAsYiidActivitiesOfActiveDealForUser as $lActivity) { ?>
	  		<?php $lUrl = $lActivity->getDeal()->getDomainProfile()->getUrl(); ?>
	     	<li><img src="http://www.google.com/s2/u/0/favicons?domain=<?php echo $lUrl; ?>" width="12" height="14" alt="<?php echo $lUrl; ?>" title="<?php echo $lUrl; ?>" /><a href="<?php echo url_for('@get_coupon_used?activityid='.$lActivity->getId()); ?>" class="active show-deal-link"><?php echo $lUrl; ?></a></li>
	      <li><img src="/img/dozen-icon.gif" width="13" height="15" alt="Dozenten-Scout" title="Dozenten-Scout" /> <a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">Dozenten-Scout</a></li>
	      <li><img src="/img/ria-icon.jpg" width="13" height="14" alt="ripanti.com" title="ripanti.com" /><a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">ripanti.com</a></li>
	      <li><img src="/img/ria-icon.jpg" width="13" height="14" alt="Brille24" title="Brille24" /><a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">Brille24</a></li>
	    	<?php } ?>
	    </ul>
	  </div>
	<?php } else { ?>
		<div class="whtboxpad">
			<?php echo __('No active deals!'); ?>
		</div>
	<?php } ?>
</div>
<div class="whtboxbot"><span></span></div>