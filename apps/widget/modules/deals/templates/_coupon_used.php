<?php use_helper("Date"); ?>
<?php $lDeal = $pActivity->getDeal(); ?>
<div class="grboxtop"><span></span></div>
<div class="grboxmid">
	<div class="grboxmid-content">
		<div class="graybox clearfix">
    	<div class="clearfix spactsbox" id="coupon-head-summary">
      	<span><?php echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($lDeal->getSummary(), '/'))); ?></span>
     	</div>
    <div class="dotborboxsmall dotborboxmore">
    	<h2 class="graytitle txtcenter"><?php echo $lDeal->getDescription(); ?></h2>
      <div class="whtrow codebox">
    		<div class="rcor">
        	<span class="fs13"><?php echo __('Your coupon code:'); ?></span><br /><span class="code"><?php echo $pActivity->getCCode();?></span>
        </div>
      </div>
    </div>
    <div class="htplinks"><a href="<?php echo url_for($lDeal->getRedeemUrl()); ?>"><?php echo $lDeal->getRedeemUrl(); ?></a></div>
		</div>
	</div>
</div>
<div class="grboxbot"><span></span></div>