<section class="buttontabsection clearfix">
<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>
<form action="<?php echo url_for('deals/step_billing?did='.$pDealId); ?>" id="deal_billing_form" name="create_deal_form" method="POST">
	<?php echo $pPaymentMethodForm['_csrf_token']->render(); ?>
<div class="alignright tabcontainer">
	<div id="tab4" class="tabcontent" >
		<div class="stepitem kampagnecontent clearfix">
			<div class="alignleft leftpart first">
				<h3 class="toptitle"><?php echo __('Schritt 4: Rechnungsadresse')?></h3>
				<div class="contentbox">
					<span class="clearfix checkitem"><input type="radio" class="alignleft" name="existing_pm_id" value="false" checked/><h3><?php echo __('Neue Adresse eingeben'); ?></h3></span>
					<ul class="clearfix addressdetail-list">
						<li>
							<span class="label"><?php echo $pPaymentMethodForm['company']->renderLabel(); ?></span>
							<label class="address-input"><?php echo $pPaymentMethodForm['company']->render(); ?></label>
							<?php echo $pPaymentMethodForm['company']->renderError(); ?>
						</li>
						<li>
							<span class="label"><?php echo $pPaymentMethodForm['contact_name']->renderLabel(); ?></span>
							<label class="address-input"><?php echo $pPaymentMethodForm['contact_name']->render(); ?></label>
							<?php echo $pPaymentMethodForm['contact_name']->renderError(); ?>
						</li>
						<li>
							<span class="label"><?php echo $pPaymentMethodForm['address']->renderLabel(); ?></span>
							<label class="address-input"><?php echo $pPaymentMethodForm['address']->render(); ?></label>
							<?php echo $pPaymentMethodForm['address']->renderError(); ?>
						</li>
						<li>
							<span class="label"><?php echo $pPaymentMethodForm['zip']->renderLabel(); ?></span>
							<label class="address-input"><?php echo $pPaymentMethodForm['zip']->render(); ?></label>
							<?php echo $pPaymentMethodForm['zip']->renderError(); ?>
						</li>
						<li class="last">
							<span class="label"><?php echo $pPaymentMethodForm['city']->renderLabel(); ?></span>
							<label class="address-input"><?php echo $pPaymentMethodForm['city']->render(); ?></label>
							<?php echo $pPaymentMethodForm['city']->renderError(); ?>
						</li>
					</ul>
				</div>
				<?php if (count($pPaymentMethods) > 0) { ?>
				<div class="contentbox clearfix">
					<h3><?php echo __('Adresse auswählen'); ?></h3>
					<?php foreach($pPaymentMethods as $lPayMethod) { ?>
					<div class="addressbox">
						<input type="radio" class="alignleft" name="existing_pm_id" value="<?php echo $lPayMethod->getId(); ?>" />
						<ul class="select-address-list alignleft clearfix">
							<li><?php echo $lPayMethod->getCompany(); ?></li>
							<li><?php echo $lPayMethod->getContactName(); ?></li>
							<li><?php echo $lPayMethod->getAddress(); ?></li>
							<li><?php echo $lPayMethod->getZip(); ?> <?php echo $lPayMethod->getCity(); ?></li>
						</ul>
					</div>
					<?php } ?>
				</div>
			<?php }//end if paymentmethods?>
			</div>
			<div class="alignright rightpart">
				<h3><?php echo __('Rechnungsadresse'); ?></h3>
				<p><?php echo __('Bitte geben Sie hier Ihre Rechnungsadresse ein falls Sie von der uns vorliegenden Adresse abweicht.'); ?></p>
			</div>
		</div>
		<span class="btnbarlist"><label class="pink-btn"><input type="submit" value="<?php echo __('Weiter'); ?>"></label></span>
	</div>
</div>
</form>
</section>