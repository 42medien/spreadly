<?php slot('content') ?>
<?php if ($pUser->hasApiMethod()) {?>

	<?php echo __('Sie haben bereits einen API-Key beantragt. Sollten Sie dazu noch Fragen oder irgendwelche Probleme haben, schreiben sie uns doch bitte eine email an api@spreadly.com'); ?>

<?php } else { ?>


<form action="<?php echo url_for('advertiser/apply_api'); ?>" id="apply_deal_form" name="apply_deal_form" method="POST">
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Rechnungsadresse auswählen')?></h2>
	<?php echo $pPaymentMethodForm['_csrf_token']->render(); ?>
		<input type="radio" class="alignleft" name="existing_pm_id" value="false" checked/>
		<ul class="btnformlist alignleft">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pPaymentMethodForm['company']->renderLabel(); ?></strong><span><?php echo $pPaymentMethodForm['company']->renderError(); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
	      		<?php echo $pPaymentMethodForm['company']->render(array('class' => 'wd350')); ?>
	      	</span>
	      </label>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pPaymentMethodForm['contact_name']->renderLabel(); ?></strong><span><?php echo $pPaymentMethodForm['contact_name']->renderError(); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
	      		<?php echo $pPaymentMethodForm['contact_name']->render(array('class' => 'wd350')); ?>
	      	</span>
	      </label>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pPaymentMethodForm['address']->renderLabel(); ?></strong><span><?php echo $pPaymentMethodForm['address']->renderError(); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
	      		<?php echo $pPaymentMethodForm['address']->render(array('class' => 'wd350')); ?>
	      	</span>
	      </label>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pPaymentMethodForm['zip']->renderLabel(); ?></strong><span><?php echo $pPaymentMethodForm['zip']->renderError(); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
	      		<?php echo $pPaymentMethodForm['zip']->render(array('class' => 'wd350')); ?>
	      	</span>
	      </label>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pPaymentMethodForm['city']->renderLabel(); ?></strong><span><?php echo $pPaymentMethodForm['city']->renderError(); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
	      		<?php echo $pPaymentMethodForm['city']->render(array('class' => 'wd350')); ?>
	      	</span>
	      </label>
	    </li>
		</ul>
		<?php foreach($pPaymentMethods as $lPayMethod) { ?>
		<input type="radio" class="alignleft" name="existing_pm_id" value="<?php echo $lPayMethod->getId(); ?>" />
			<ul class="select-address-list alignleft clearfix">
				<li><?php echo $lPayMethod->getCompany(); ?></li>
				<li><?php echo $lPayMethod->getContactName(); ?></li>
				<li><?php echo $lPayMethod->getAddress(); ?></li>
				<li><?php echo $lPayMethod->getZip(); ?> <?php echo $lPayMethod->getCity(); ?></li>
			</ul>
		<?php } ?>
		<input type="submit" id="create_deal_button" value="<?php echo __('Api-Key beantragen'); ?>" class="alignright" />
	</div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Api-Key beantragen'); ?></h2>
		<p><?php echo __('Um einen Api-Key zu beantragen, geben Sie bitte eine dafür notwendige, gültige Rechnungsadresse an. Wir setzen und dann umgehend mit Ihnen in Verbindung und sie bekommen die API-Keys zugesendet.'); ?></p>
	</div>
</form>
<?php } ?>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
