<?php include_partial('deals/breadcrumb'); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_share?did='.$pDealId); ?>" name="create_deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<?php echo $pForm['motivation_title']->renderLabel(); ?>
	<?php echo $pForm['motivation_title']->render(); ?>
	<?php echo $pForm['motivation_title']->renderError(); ?>

	<?php echo $pForm['motivation_text']->renderLabel(); ?>
	<?php echo $pForm['motivation_text']->render(); ?>
	<?php echo $pForm['motivation_text']->renderError(); ?>

	<?php echo $pForm['spread_title']->renderLabel(); ?>
	<?php echo $pForm['spread_title']->render(); ?>
	<?php echo $pForm['spread_title']->renderError(); ?>

	<?php echo $pForm['spread_text']->renderLabel(); ?>
	<?php echo $pForm['spread_text']->render(); ?>
	<?php echo $pForm['spread_text']->renderError(); ?>

	<?php echo $pForm['spread_url']->renderLabel(); ?>
	<?php echo $pForm['spread_url']->render(); ?>
	<?php echo $pForm['spread_url']->renderError(); ?>

	<?php echo $pForm['spread_img']->renderLabel(); ?>
	<?php echo $pForm['spread_img']->render(); ?>
	<?php echo $pForm['spread_img']->renderError(); ?>

	<?php echo $pForm['spread_tos']->renderLabel(); ?>
	<?php echo $pForm['spread_tos']->render(); ?>
	<?php echo $pForm['spread_tos']->renderError(); ?>

<input type="submit" id="create_deal_button" />

</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>