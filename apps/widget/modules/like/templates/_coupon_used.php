<?php use_helper("Date", "YiidUrl"); ?>
<?php $lDeal = $pActivity->getDeal(); ?>
<div class="grboxtop"><span></span></div>
<div class="grboxmid">
	<div class="grboxmid-content">
		<div class="graybox clearfix">
    	<div class="clearfix spactsbox" id="coupon-head-summary">
      	<span><?php echo __('Click "Like" and get ...'); ?></span>
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
	</div>
</div>
<div class="grboxbot"><span></span></div>