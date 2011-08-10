<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<form action="<?php echo url_for('deals/step_submitted?did='.$pDealId); ?>" name="create_deal_form" method="POST">
<?php slot('content') ?>
	<div class="createbtnbox alignleft ">
		<h2 class="btntitle"><?php echo __('Step 1: Your campaign')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Campaign name'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getName(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Target quantity'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getTargetQuantity(); ?>
	      </span>
	    </li>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Ihre Spreadly Kampagne'); ?></h2>
		<p><?php echo __('Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen Sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien. Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen.'); ?></p>
		<p><?php echo link_to('Edit your campaign settings', 'deals/step_campaign?did='.$pDeal->getId()); ?></p>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 2: Your share settings')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Motivation title'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getMotivationTitle(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Motivation text'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getMotivationText(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread title'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadTitle(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread text'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadText(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread url'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadUrl(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread image'); ?>:</strong>
	      </div>
	      <span>
	      	<img src="<?php echo $pDeal->getSpreadImg(); ?>" width="100" height="80"/>
	      	<?php echo $pDeal->getSpreadImg(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread TOS'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadTos(); ?>
	      </span>
	    </li>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<!-- screen von deal-like -->
		<?php echo link_to('Edit your sharing settings', 'deals/step_share?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 3: Your coupon settings')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Coupon title'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponTitle(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Coupon text'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponText(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('The Coupon type'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponType(); ?>
	      </span>
	    </li>

	    <?php if ($pDeal->getCouponType() == "code") {?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Coupon code'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponCode(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Redeem url'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponRedeemUrl(); ?>
	      </span>
	    </li>
	    <?php } else { ?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Url'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponUrl(); ?>
	      </span>
	    </li>
	    <?php } ?>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<!-- screen von deal-like -->
		<?php echo link_to('Edit your coupon settings', 'deals/step_coupon?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 4: Your payment settings')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Payment method'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getType(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Company'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getCompany(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Contact name'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getContactName(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Address'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getAddress(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Zip'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getZip(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('City'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getCity(); ?>
	      </span>
	    </li>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Your payment method'); ?></h2>
		<p><?php echo __('Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen Sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien. Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen.'); ?></p>
		<p><?php echo link_to('Edit your payment settings', 'deals/step_billing?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<div class="clearfix">
	<p><?php echo __('Are you sure for your settings? If so, click "send deal" and your deal will be submitted. We will send you an email if we approve the deal.'); ?></p>
	<input type="submit" class="alignright" id="create_deal_button" value="<?php echo __('Send deal'); ?>" />
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
</form>
