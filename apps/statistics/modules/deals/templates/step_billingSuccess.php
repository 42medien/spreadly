<?php include_partial('deals/breadcrumb'); ?>


<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_billing?did='.$pDealId); ?>" name="create_deal_form" method="POST">
	<?php //echo $pForm->renderGlobalErrors(); ?>
	<?php //var_dump($pForm->getEmbeddedForm('payment_method'));die(); ?>
	<?php echo $pForm['tos_accepted']->renderLabel();?>
	<?php echo $pForm['tos_accepted']->render();?>
	<?php echo $pForm['tos_accepted']->renderError();?>

	<?php echo $pForm['payment_method']['company']->renderLabel(); ?>
	<?php echo $pForm['payment_method']['company']->render(); ?>
	<?php echo $pForm['payment_method']['company']->renderError(); ?>

	<?php echo $pForm['payment_method']['contact_name']->renderLabel(); ?>
	<?php echo $pForm['payment_method']['contact_name']->render(); ?>
	<?php echo $pForm['payment_method']['contact_name']->renderError(); ?>

	<?php echo $pForm['payment_method']['address']->renderLabel(); ?>
	<?php echo $pForm['payment_method']['address']->render(); ?>
	<?php echo $pForm['payment_method']['address']->renderError(); ?>

	<?php echo $pForm['payment_method']['city']->renderLabel(); ?>
	<?php echo $pForm['payment_method']['city']->render(); ?>
	<?php echo $pForm['payment_method']['city']->renderError(); ?>

	<?php echo $pForm['payment_method']['zip']->renderLabel(); ?>
	<?php echo $pForm['payment_method']['zip']->render(); ?>
	<?php echo $pForm['payment_method']['zip']->renderError(); ?>

	<?php //echo $pForm->getEmbeddedForm('PaymentMethod')->render(); ?>

<input type="submit" id="create_deal_button" />

</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
