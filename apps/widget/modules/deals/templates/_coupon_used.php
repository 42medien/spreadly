<?php use_helper("Date", "YiidUrl"); ?>
<?php $lDeal = $pActivity->getDeal(); ?>
<div class="grboxtop"><span></span></div>
<div class="grboxmid">
	<div class="grboxmid-content">

		<?php if($lDeal->getCouponType() != 'html') { ?>
		<div class="graybox clearfix">
    	<div class="clearfix spactsbox" id="coupon-head-summary">
      	<span><?php echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($lDeal->getSummary(), '/'))); ?></span>
     	</div>
    <div class="dotborboxsmall dotborboxmore">
    	<h2 class="graytitle txtcenter"><?php echo $lDeal->getDescription(); ?></h2>
      <div class="whtrow codebox">
    		<div class="rcor">
        	<span class="fs13">
        	  <?php
            if (UrlUtils::isUrlValid($pActivity->getCCode())) {
              echo __('Get your download here:');
            } else {
              echo __('Your Coupon Code:');
            }
            ?>
          </span><br /><span class="code"><?php echo auto_link_to($pActivity->getCCode(), 30, array('target' => '_blank'));?></span>
        </div>
      </div>
    </div>
    <div class="htplinks"><a target="_blank" href="<?php echo url_for($lDeal->getRedeemUrl()); ?>"><?php echo $lDeal->getRedeemUrl(); ?></a></div>
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