<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<form action="<?php echo url_for('deals/step_verify?did='.$pDealId); ?>" name="create_deal_form" id="deal_verify_form" method="POST">
<?php slot('content') ?>
	<div class="createbtnbox alignleft" id="verify-campaign">
		<h2 class="btntitle"><?php echo __('Schritt 5: Prüfen')?></h2>
		<h2 class="btntitle"><?php echo __('Kampagne anlegen')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Name'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getName(); ?>
	      </span>
	    </li>

	    <?php if ($pDeal->getBillingType() == 'like' ){ ?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Streuung nach Likes'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo __($pDeal->getTargetQuantity().' Likes für '.$pDeal->getPrice()." Euro"); ?>
	      </span>
	    </li>
	    <?php } else {?>
		    <li class="clearfix">
		    	<div class="btnwording alignleft">
		      	<strong><?php echo __('Streuung nach Reichweite'); ?>:</strong>
		      </div>
		      <span>
		      	<?php echo __($pDeal->getTargetQuantity().' erreichte User für '.$pDeal->getPrice()." Euro"); ?>
		      </span>
		    </li>
		  <?php } ?>

		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Deal Kampagnen von Spreadly'); ?></h2>
		<p><?php echo __('Sie haben eine gute Entscheidung getroffen, denn Sie zahlen nur für die tatsächlich erzielte Reichweite Ihrer Kampagne.<br/> Ihr Deal erscheint für den Teilnehmer als Angebot im Like-Popup von Spreadly.<br/> Sie erreichen so eine internetaffine Zielgruppe, die gern Inhalte über verschiedene Social Media Kanäle verbreitet.<br/> Gestalten Sie Ihr Angebot so reizvoll wie möglich, damit sich schnell der von Ihnen gewünschte Erfolg einstellt. In den Statistiken können Sie jederzeit die Resonanz Ihrer Kampagne prüfen.'); ?></p>
		<p><?php echo link_to('Bearbeiten der Kampagne', 'deals/step_campaign?did='.$pDeal->getId()); ?></p>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Deal definieren')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Motivator'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getMotivationTitle(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Motivationstext'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getMotivationText(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread Werbung'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getSpreadTitle(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread Teaser'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getSpreadText(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread URL'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadUrl(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread Bild'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadImg(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Spread AGB'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getSpreadTos(); ?>
	      </span>
	    </li>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<?php include_partial('deals/popup_share', array('pDeal' => $pDeal))?>
		<?php echo link_to('Bearbeiten des Deals', 'deals/step_share?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Bearbeiten des Gutscheins')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Name des Gutscheins'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getCouponTitle(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutscheintext'); ?>:</strong>
	      </div>
	      <div class="alignleft wd415">
	      	<?php echo $pDeal->getCouponText(); ?>
	      </div>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutscheinquelle'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponType(); ?>
	      </span>
	    </li>

	    <?php if ($pDeal->getCouponType() == "code") {?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutschein Code'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponCode(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutschein einlösen'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponRedeemUrl(); ?>
	      </span>
	    </li>
	    <?php } elseif ($pDeal->getCouponType() == "unique_code") { ?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Webhook Url'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponWebhookUrl(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutschein einlösen'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponRedeemUrl(); ?>
	      </span>
	    </li>
	    <?php } else { ?>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Gutschein/Download URL'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getCouponUrl(); ?>
	      </span>
	    </li>
	    <?php } ?>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<?php if ($pDeal->getCouponType() == "code") {?>
			<?php include_partial('deals/coupon_code', array('pDeal' => $pDeal)); ?>
		<?php } else if($pDeal->getCouponType() == "url") { ?>
			<?php include_partial('deals/coupon_url', array('pDeal' => $pDeal)); ?>
		<?php } else {?>
			<?php include_partial('deals/coupon_download', array('pDeal' => $pDeal)); ?>
		<?php }?>
		<?php echo link_to('Bearbeiten des Gutscheins', 'deals/step_coupon?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Rechnungsadresse')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Zahlungsart'); ?>:</strong>
	      </div>
	      <span><?php echo __('Rechnung'); ?>
	      	<?php //echo $pDeal->getPaymentMethod()->getType(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Unternehmen'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getCompany(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Ansprechpartner'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getContactName(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Straße / Postfach'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getAddress(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('PLZ'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getZip(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo __('Ort'); ?>:</strong>
	      </div>
	      <span>
	      	<?php echo $pDeal->getPaymentMethod()->getCity(); ?>
	      </span>
	    </li>
		</ul>
	</div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Rechnungsadresse'); ?></h2>
		<p><?php echo __('Bitte überprüften Sie, ob die Rechnungsdaten richtig sind.'); ?></p>
		<p><?php echo link_to('Bearbeiten der Rechnungsadresse', 'deals/step_billing?did='.$pDeal->getId()); ?>
	</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<div class="clearfix">
	<p><?php echo __('Sind Sie sicher, dass alle Eingaben korrekt sind? Sie lassen sich nach dem Absenden nicht mehr ändern. Wenn ja, klicken Sie bitte auf „Deal senden“. Sie erhalten nach der Freigabe durch das Spreadly-Team eine Mail und Ihr Like Angebot wird umgehend in unserem Pool geschaltet.'); ?></p>
 	<div class="clearfix"><?php echo $pForm['tos_accepted']->render(array('class'=>'alignleft')); ?>&nbsp;<strong class="alignleft"><?php echo $pForm['tos_accepted']->renderLabel(); ?></strong></div>
 	<div class="clearfix"><?php echo $pForm['tos_accepted']->renderError(); ?></div>
	<input type="submit" class="alignright" id="create_deal_button" value="<?php echo __('Deal senden'); ?>" />
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
</form>
