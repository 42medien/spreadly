<?php use_helper("Date"); ?>
<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title"><?php echo __("Recent Deal"); ?></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
	<div class="popwidecol" id="coupon-unused-container">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
				<div class="graybox clearfix rempvepad">
				<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
    			<input type="hidden" name="like[url]" value="<?php echo $pUrl; ?>" />
    			<input type="hidden" name="like[tags]" value="<?php echo $pTags; ?>" />
    			<div class="clearfix spactsbox" id="coupon-head-summary">
      			<span><?php echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($pDeal->getSummary(), '/'))); ?></span>
      		</div>
          <div class="dotborbox">
          	<h2 class="graytitle"><?php echo $pDeal->getSummary(); ?></h2>
            <div class="whtrow">
            	<div class="rcor"><?php echo $pDeal->getDescription(); ?></div>
            </div>
            <p class="exprebox"><?php if ($pDeal->isUnlimited()) {
                echo __("%1 Claimed Deals", array("%1" => $pDeal->getCouponClaimedQuantity()));
              } else {
                echo __("%1/%2 Deals left", array("%1" => $pDeal->getCouponClaimedQuantity(), "%2" => $pDeal->getCouponQuantity()));
              } ?></p>
          </div>
          <div class="dieblock">
<!--<a class="graybtn alignright" title="Copy code" href="#"><span><em class="pleasemeicon">Gefallt mir</em></span></a> -->
          	<span class="alignleft ekrenne"><label class="radio-btn"> <input type="checkbox" name="" /></label><?php echo __("I accept the %1.", array("%1" => link_to(__("Terms of Services"), $pActiveDeal->getTermsOfDeal(), array("target" => "_blank")))); ?></span>
          	<span class="alignmiddle btn"><input type="submit" id="popup-send-deal-button" value="Spread It" /></span>
          </div>
          </form>
				</div>
      </div>
    </div>
    <div class="grboxbot"><span></span></div>
  </div>
</div>
<div class="whtboxbot"><span></span></div>