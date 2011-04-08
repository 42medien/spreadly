<form action="/analytics/get_domain_detail" name="analytics-filter-form" id="analytics-datefilter-form">
<input type="hidden" name="domainid" value="<?php echo $pDomainId; ?>" />
<div class="alignleft zeitraumblock clearfix" style="height: 200px;">
	<h2 class="webtitle"><?php echo __('Period'); ?></h2>
	<div class="alignleft clearfix" style="width: 300px;">
  <label class="textfield-whtmid">
  	<span>
  		<input type="text" id="date-filter-from" class="wd172" name="date-from" value="<?php echo $pDateFrom ?>" />
  		<div id="datefrombox" style="width: 300px">&nbsp;</div>
  	</span>
  </label>
  </div>
  <span class="alignleft deshline"> - </span>
  <div class="alignleft clearfix">
  <label class="textfield-whtmid">
  	<span>
  		<input type="text" class="wd172" id="date-filter-to" name="date-to" value="<?php echo $pDateTo ?>" />
  		<div id="datetobox" style="width: 300px">&nbsp;</div>
  	</span>
  </label>
  </div>
</div>
</form>
<script type="text/javascript">
	AnalyticsFilter.initDatepicker({
	  direction: 'down'
	});
</script>