<?php use_helper("Date", "YiidUrl"); ?>
<?php $lDeal = $pActivity->getDeal();?>
<?php slot('headline') ?>
	<h2><?php echo __('Congratulation'); ?></h2>
<?php end_slot(); ?>

		<?php if($lDeal->getCouponType() != 'html') { ?>
			<div class="coupon clearfix">
				<?php echo image_tag($lDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
				<div class="alignleft">
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
			<div class="graybox clearfix">
	    	<div class="clearfix spactsbox" id="coupon-head-summary">
	      	<h2><?php echo __('Gratulation'); ?></h2>
	     	</div>
		    <div class="dotborboxsmall dotborboxmore txtcenter" id="dotboxtextdeal">
					<?php echo $pActivity->getCCode(); ?>
		    </div>
			</div>
		<?php } ?>
	</div>
</div>
<div class="grboxbot"><span></span></div>