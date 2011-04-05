<div><?php echo __('Period'); ?>:
	<label id="websel" for="host_id">
		<select class="custom-select" id="filter_period" name="filter_period">
			<option value="today"><?php echo __('Today'); ?></option>
			<option value="yesterday" selected="selected"><?php echo __('Yesterday'); ?></option>
			<option value="lastweek"><?php echo __('Last week'); ?></option>
			<option value="lastmonth"><?php echo __('Last month'); ?></option>
			<option value="all"><?php echo __('All'); ?></option>
	  </select>
	</label>
	<?php echo link_to('Other period', '/', array('id' => 'select-period-link')); ?>
</div>