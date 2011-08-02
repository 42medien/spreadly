<?php include_partial('deals/breadcrumb'); ?>


<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_campaign?did='.$pDealId); ?>" name="create_deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>

	<?php echo $pForm['name']->renderLabel(); ?>
	<?php echo $pForm['name']->render(); ?>
	<?php echo $pForm['name']->renderError(); ?>

	<?php echo $pForm['target_quantity']->renderLabel(); ?>
	<?php echo $pForm['target_quantity']->render(); ?>
	<?php echo $pForm['target_quantity']->renderError(); ?>

<input type="submit" id="create_deal_button" />

</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

