<?php use_helper('YiidUrl'); ?>
<?php slot('content') ?>
<div id="analytics-bread">
	<ul class="bc-list clearfix">
		<li class="bc-first"></li>
		<li class="bc-gradient"><?php echo link_to(__('Dashboard'), 'analytics/index'); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><?php echo link_to('Overview for '.$pDomainProfile->getUrl(), 'analytics/domain_statistics?domainid='.$pDomainProfile->getId()); ?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><?php echo link_to('Details for '.$pDomainProfile->getUrl(), 'analytics/domain_detail?domainid='.$pDomainProfile->getId());?></li>
		<li class="bc-seperator"></li>
		<li class="bc-gradient"><strong><?php echo __('Details for '.$pUrl); ?></strong></li>
		<li class="bc-last"></li>
	</ul>
</div>

<form action="/analytics/get_url_detail" name="analytics-filter-form" id="analytics-filter-form">
  <input type="hidden" name="domainid" value="<?php echo $pDomainProfile->getId(); ?>" />
  <input type="hidden" name="url" value="<?php echo $pUrl; ?>" />
  <input type="hidden" id="datefromfield" name="date-from" value="<?php echo $datefrom; ?>" />
  <input type="hidden" id="datetofield" name="date-to" value="<?php echo $dateto; ?>" />
<div class="clearfix">
  <label for="host_id" id="filter-period-label" class="alignleft">
    <select class="custom-select" id="filter_period" name="date-selector">
      <option value="now" <?php echo ($selector == 'now') ? 'selected="selected"':""; ?>><?php echo __('Today'); ?></option>
      <option value="yesterday" <?php echo ($selector == 'yesterday') ? 'selected="selected"':""; ?>><?php echo __('Yesterday'); ?></option>
      <option value="7" <?php echo ($selector == '7') ? 'selected="selected"':""; ?>><?php echo __('Last 7 days'); ?></option>
      <option value="30" <?php echo ($selector == '30') ? 'selected="selected"':""; ?>><?php echo __('Last 30 days'); ?></option>
    </select>
  </label>
    <span class="alignleft" id="filter-period-or"><?php echo __('or'); ?></span>
    <?php echo link_to('<span>'.__('Other period').'</span>', 'analytics/select_period?url='.$pUrl.'&domainid='.$pDomainProfile->getId(), array('id' => 'select-period-link', 'class' => 'colorbox alignleft button')); ?>
</div>
</form>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<div id="domain-detail-content">

</div>