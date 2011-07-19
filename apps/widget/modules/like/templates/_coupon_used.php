<?php use_helper("Date", "YiidUrl"); ?>
<?php $lDeal = $pActivity->getDeal();?>

		<?php if($lDeal->getCouponType() != 'html') { ?>
			<div class="coupon shadow-light bordered-light clearfix">
				<?php echo image_tag($lDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
				<div class="alignleft" id="coupon-text">
					<h4><?php echo $lDeal->getSummary(); ?><?php //echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($lDeal->getSummary(), '/'))); ?></h4>
	    		<p><?php echo $lDeal->getDescription(); ?></p>
	    		<p>
	   	  		<?php
	           if (UrlUtils::isUrlValid($pActivity->getCCode())) {
	              echo __('Get your download here:');
	            } else {
	              echo __('Your Coupon Code:');
	            }
	         	?>
	          <span class="coupon-code">
	          	<?php echo auto_link_to($pActivity->getCCode(), 30, array('target' => '_blank'));?>
						</span>
	    		</p>
	    	</div>
			</div>
			<div id="tos-area" class="clearfix">
				<span class="alignright">
					<?php echo __('You can redeem it on'); ?> <a target="_blank" href="<?php echo url_for($lDeal->getRedeemUrl()); ?>"><?php echo $lDeal->getRedeemUrl(); ?></a>
    		</span>
			</div>
		<?php } else { ?>
			<div class="coupon clearfix">
				<?php echo image_tag($lDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
				<div class="alignleft" id="coupon-text">
					<?php echo $pActivity->getCCode(); ?>
				</div>
			</div>
		<?php } ?>