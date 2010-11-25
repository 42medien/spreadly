<form action="/deals/testerle" method="post" name="deal_form">

<?php echo $pForm->render();?>
  <?php echo $pForm['_csrf_token']->render(); ?>
	<input type="submit" class="button positive" value="<?php echo __('Save', null, 'widget');?>" />
</form>