<?php include_partial('deals/breadcrumb'); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_coupon?did='.$pDealId); ?>" name="create_deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<?php echo $pForm['coupon_type']->renderLabel(); ?>
	<?php echo $pForm['coupon_type']->render(); ?>
	<?php echo $pForm['coupon_type']->renderError(); ?>

	<?php echo $pForm['coupon_title']->renderLabel(); ?>
	<?php echo $pForm['coupon_title']->render(); ?>
	<?php echo $pForm['coupon_title']->renderError(); ?>

	<?php echo $pForm['coupon_text']->renderLabel(); ?>
	<?php echo $pForm['coupon_text']->render(); ?>
	<?php echo $pForm['coupon_text']->renderError(); ?>

	<?php echo $pForm['coupon_code']->renderLabel(); ?>
	<?php echo $pForm['coupon_code']->render(); ?>
	<?php echo $pForm['coupon_code']->renderError(); ?>

	<?php echo $pForm['coupon_url']->renderLabel(); ?>
	<?php echo $pForm['coupon_url']->render(); ?>
	<?php echo $pForm['coupon_url']->renderError(); ?>

	<?php echo $pForm['coupon_redeem_url']->renderLabel(); ?>
	<?php echo $pForm['coupon_redeem_url']->render(); ?>
	<?php echo $pForm['coupon_redeem_url']->renderError(); ?>

	<input type="submit" id="create_deal_button" />

</form>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>