<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;
	<?php echo link_to($pDomainProfile->getUrl(), 'analytics/domain_statistics?domainid='.$pDomainProfile->getId()); ?>&nbsp;
	<?php echo __('Overview'); ?>
</div>
<form action="/analytics/get_domain_detail" name="analytics-filter-form" id="analytics-filter-form">
<input type="hidden" name="domainid" value="<?php echo $pDomainProfile->getId(); ?>" />
<div>
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
</form>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<div id="domain-detail-content">
<?php include_partial('analytics/domain_detail_content', array('pHost' => $pHost, "pDeals" => $pDeals)); ?>
</div>
