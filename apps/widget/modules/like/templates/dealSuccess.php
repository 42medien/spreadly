<?php use_helper("Date"); ?>

<?php //include_partial('like/coupon_unused', array('pDeal' => $pActiveDeal, 'pUrl' => $pUrl, 'pTags' => $pTags)); ?>

<form action="<?php echo url_for('@save_like'); ?> " name="popupdealform" id="popupdealform" method="post">

    <input type="hidden" name="like[url]" value="<?php echo $pUrl; ?>" />
    <input type="hidden" name="like[tags]" value="<?php echo $pTags; ?>" />

    <div class="whtboxtopwide spreadsel_box">
      <div class="rcor clearfix">
        <div class="alignleft checklist">
          <ul class="clearfix">
            <?php foreach($pIdentities as $lIdentity) {?>
            <li>
              <input type="checkbox" class="checkbox dealcheckbox" name="like[oiids][]" value="<?php echo $lIdentity->getId(); ?>" <?php if ($lIdentity->getSocialPublishingEnabled()) { echo "checked='checked'"; }  ?> /><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getCommunity()->getName(), "title" => $lIdentity->getCommunity()->getName())); ?>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>

    <div class="wht-contentbox clearfix">
			<div class="popwidecol" id="coupon-unused-container">
		  	<div class="grboxtop"><span></span></div>
		    <div class="grboxmid">
		    	<div class="grboxmid-content">
						<div class="graybox clearfix rempvepad">
		    			<div class="clearfix spactsbox" id="coupon-head-summary">
		      			<span><?php echo __('Click "Like" and get ...'); ?></span>
		      		</div>
		          <div class="dotborbox">
		          	<h2 class="graytitle"><?php echo $pActiveDeal->getSummary(); ?></h2>
		            <div class="whtrow">
		            	<div class="rcor clearfix">
            				<?php echo image_tag($pActiveDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
		            		<?php echo $pActiveDeal->getDescription(); ?>
		            	</div>
		            </div>
		            <p class="exprebox"><?php if ($pActiveDeal->isUnlimited()) {
                    echo __("%1 Claimed Deals", array("%1" => $pActiveDeal->getCouponClaimedQuantity()));
                  } else {
                    echo __("%1/%2 Deals left", array("%1" => $pActiveDeal->getCouponQuantity() - $pActiveDeal->getCouponClaimedQuantity(), "%2" => $pActiveDeal->getCouponQuantity()));
                  } ?></p>
		          </div>
		          <div class="dieblock">
		          	<span class="alignleft ekrenne"><input type="checkbox" id="liketos" class="checkbox dealcheckbox" name="like[tos]" /><?php echo __("I accept the %1.", array("%1" => link_to(__("Terms of Services"), $pActiveDeal->getTermsOfDeal(), array("target" => "_blank")))); ?>&nbsp;<?php echo $pActiveDeal->getAdditionalTos(); ?></span>
          			<span class="error ekrenne" style="display: none;"><?php echo __('Please check your selected services to share and accept the TOS'); ?></span>
		          	<span class="alignmiddle btn" id="popup-send-deal-box"><input type="submit" id="popup-send-deal-button" value="" /></span>
		          </div>
						</div>
		      </div>
		    </div>
		    <div class="grboxbot"><span></span></div>
		  </div>
    </div>
</form>
