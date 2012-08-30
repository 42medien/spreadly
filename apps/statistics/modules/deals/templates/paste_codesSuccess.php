<h2><?php echo __('Add more Coupon Codes'); ?></h2>
<p><?php echo __('Paste codes coma-separated or one code per line'); ?></p>
<form action="<?php echo url_for('deals/save_codes'); ?>" method="post" id="save_codes_form" name="save_codes_form">
<input type="hidden" name="deal_id" value="<?php echo $pDealId; ?>" />
<textarea id="add-codes-area" name="multiple_codes"></textarea>
<input type="submit" class="button positive" value="<?php echo __('Add');?>" />
<?php echo __('or'); ?>&nbsp;&nbsp;
<?php echo link_to(__('Cancel'), '/', array('id'=>'cancel_layer')); ?>
</form>
<script type="text/javascript">
	DealTable.saveCodes();
	DealTable.cancelLayer();
</script>