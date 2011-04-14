<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;
	<?php echo link_to($pDomainProfile->getUrl(), 'analytics/domain_statistics?domainid='.$pDomainProfile->getId()); ?>&nbsp;
	<?php echo __('Overview'); ?>
</div>
<form action="/analytics/get_domain_detail" name="analytics-filter-form" id="analytics-filter-form">
	<input type="hidden" name="domainid" value="<?php echo $pDomainProfile->getId(); ?>" />
<div class="clearfix">
	<label for="host_id" id="filter-period-label" class="alignleft">
		<select class="custom-select" id="filter_period" name="date-to">
			<option value="<?php echo date("Y-m-d", strtotime("now")); ?>"><?php echo __('Today'); ?></option>
			<option value="<?php echo date("Y-m-d", strtotime("yesterday")); ?>" selected="selected"><?php echo __('Yesterday'); ?></option>
			<option value="<?php echo date("Y-m-d", strtotime("7 days ago")); ?>"><?php echo __('Last week'); ?></option>
			<option value="<?php echo date("Y-m-d", strtotime("30 days ago")); ?>"><?php echo __('Last month'); ?></option>
	  </select>
	</label>
		<span class="alignleft" id="filter-period-or"><?php echo __('or'); ?></span>
		<?php echo link_to('<span>'.__('Other period').'</span>', 'analytics/select_period?domainid='.$pDomainProfile->getId(), array('id' => 'select-period-link', 'class' => 'colorbox button')); ?>
</div>
</form>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<div id="domain-detail-content">
<?php include_partial('analytics/domain_detail_content', array('pHost' => $pHost, "pDeals" => $pDeals)); ?>
</div>
