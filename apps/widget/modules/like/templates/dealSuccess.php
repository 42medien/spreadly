<?php use_helper("Date", 'Text', 'YiidUrl', 'YiidNumber'); ?>

<?php //include_partial('like/coupon_unused', array('pDeal' => $pActiveDeal, 'pUrl' => $pUrl, 'pTags' => $pTags)); ?>
<?php slot('headline') ?>
	<h2><?php echo __('Click "Like" and get ...'); ?></h2>
<?php end_slot(); ?>
<div id="coupon-unused-container">
<form action="<?php echo url_for('@save_like'); ?> " name="popupdealform" id="popupdealform" method="post">
	<input type="hidden" name="like[url]" value="<?php echo $pUrl; ?>" />
  <input type="hidden" name="like[tags]" value="<?php echo $pTags; ?>" />

	<div class="coupon shadow-light bordered-light clearfix">
	  <?php echo image_tag($pActiveDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
		<div class="alignleft" id="coupon-text">
		  <h3><?php echo $pActiveDeal->getSummary(); ?></h3>
			<p><?php echo $pActiveDeal->getDescription(); ?></p>
			<p class="add-info">
				<?php if($pActiveDeal->getCouponType() != 'html') { ?>
					<?php if ($pActiveDeal->isUnlimited()) {
			    	echo __("%1 Claimed Deals", array("%1" => $pActiveDeal->getCouponClaimedQuantity()));
					} else {
			    	echo __("%1/%2 Deals left", array("%1" => $pActiveDeal->getCouponQuantity() - $pActiveDeal->getCouponClaimedQuantity(), "%2" => $pActiveDeal->getCouponQuantity()));
			    } ?>
			  <?php } ?>
			</p>
		</div>
	</div>
	<div id="tos-area" class="clearfix">
		<input type="checkbox" name="like[tos]" class="alignright" />
		<label for="like[tos]"><?php echo __("I accept the %1.", array("%1" => link_to(__("Terms of Services"), $pActiveDeal->getTermsOfDeal(), array("target" => "_blank")))); ?>&nbsp;<?php echo $pActiveDeal->getAdditionalTos(); ?></label>
	</div>
	<div id="like-submit" class="clearfix">
	<div id="like-response"></div>
  <?php //echo __('Please check your selected services to share and accept the TOS'); ?>
  <?php
    $disabled = false;
    if (!$sf_user->checkDealCredentials() || !$sf_user->isAuthenticated()) {
      $disabled = true;
    }
  ?>
		<?php if (!$sf_user->isAuthenticated() ) { ?>
			<h4><?php echo __('Please choose your favorite service for sharing.'); ?> <?php echo __('You can add additional services anytime later.'); ?></h4>
		<?php } ?>
		<input type="submit" class="alignright btn <?php if ($disabled) { echo "disabled"; } ?>" id="popup-send-deal-button" value="" <?php if ($disabled) { echo "disabled='disabled'"; } ?> />
		<ul class="clearfix" id="like-oi-list">
		<?php if (count($pIdentities) > 0) { ?>
	  	<?php foreach($pIdentities as $lIdentity) {?>
	    	<li>
					<input type="checkbox" name="like[oiids][]" value="<?php echo $lIdentity->getId(); ?>" <?php if ($lIdentity->getSocialPublishingEnabled()) { echo 'checked="checked"'; }  ?> /><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getName(), "title" => $lIdentity->getName())); ?>
	      </li>
	  	<?php } ?>
	  		<li><?php echo link_to(__('(add accounts)'), 'settings/index'); ?></li>
	  <?php } else { ?>
      <li><input class="add-service-checkbox" type="checkbox" name="facebook" value="facebook" /><?php echo link_to(image_tag("/img/facebook-favicon.gif", array("alt" => 'facebook', "title" => 'facebook')), "@signinto?service=facebook"); ?></li>
      <li><input class="add-service-checkbox" type="checkbox" name="twitter" value="twitter" /><?php echo link_to(image_tag("/img/twitter-favicon.gif", array("alt" => 'Twitter', "title" => 'Twitter')), "@signinto?service=twitter"); ?></li>
      <li><input class="add-service-checkbox" type="checkbox" name="linkedin" value="linkedin" /><?php echo link_to(image_tag("/img/linkedin-favicon.gif", array("alt" => 'Linkedin', "title" => 'Linkedin')), "@signinto?service=linkedin"); ?></li>
      <li><input class="add-service-checkbox" type="checkbox" name="google" value="google" /><?php echo link_to(image_tag("/img/google-favicon.gif", array("alt" => 'google', "title" => 'google')), "@signinto?service=google"); ?></li>
    <?php } ?>
		</ul>
</div>

</form>
</div>
