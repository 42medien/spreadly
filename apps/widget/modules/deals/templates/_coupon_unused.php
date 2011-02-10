<?php use_helper("Date"); ?>
<?php $lDeal = $pActivity->getDeal(); ?>
<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title">Recent Deals <em>(Coupons that have run out, are deleted from this list automatically)</em></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
	<div class="popwidecol" id="coupon-unused-container">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
				<div class="graybox clearfix rempvepad">
    			<div class="clearfix spactsbox" id="coupon-head-summary">
      			<span><?php echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($lDeal->getSummary(), '/'))); ?></span>
      		</div>
          <div class="dotborbox">
          	<h2 class="graytitle"><?php echo $lDeal->getSummary(); ?></h2>
            <div class="whtrow">
            	<div class="rcor"><?php echo $lDeal->getDescription(); ?></div>
            </div>
            <p class="exprebox"><?php echo __('Expires at %expire%', array('%expire%' => format_datetime($lDeal->getEndDate()))); ?>  | 87/100 left</p>
          </div>
          <div class="dieblock">
<!--<a class="graybtn alignright" title="Copy code" href="#"><span><em class="pleasemeicon">Gefallt mir</em></span></a> -->
          	<span class="alignleft ekrenne"><label class="radio-btn"> <input type="checkbox" name="" /></label>Ich erkenne die <span class="txt-blue">Teilnahmebedingungen</span> an.</span> <a href="#" class="alignright gefalt"><img src="/img/gefeatmir.png" width="89" height="32" alt="Gefallt mir" title="Gefallt mir" /></a>
          </div>
				</div>
      </div>
    </div>
    <div class="grboxbot"><span></span></div>
  </div>
</div>
<div class="whtboxbot"><span></span></div>