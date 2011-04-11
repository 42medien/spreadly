<h2><?php echo __('Select period'); ?></h2>
<form action="/analytics/get_domain_detail" name="analytics-datefilter-form" id="analytics-datefilter-form">
<input type="hidden" name="domainid" value="<?php echo $pDomainId; ?>" />

<div class="alignleft clearfix">
	<div class="clearfix">
		<span class="alignleft textfield-label"><?php echo __('Date from'); ?></span>
		<label class="textfield">
			<span><input type="text" id="date-filter-from" name="date-from" value="<?php echo $pDateFrom ?>" /></span>
		</label>
	</div>
	<div id="datefrombox" class="datepickerbox">&nbsp;</div>
</div>

<div class="alignright clearfix">
	<div class="clearfix">
		<span class="alignleft textfield-label"><?php echo __('Date to'); ?></span>
		<label class="textfield">
			<span><input type="text" id="date-filter-to" name="date-to" value="<?php echo $pDateTo ?>" /></span>
		</label>
	</div>
	<div id="datetobox" class="datepickerbox">&nbsp;</div>
</div>
</form>


<script type="text/javascript">
	AnalyticsFilter.initDatepicker();
	AnalyticsFilter.closeLayer();
</script>