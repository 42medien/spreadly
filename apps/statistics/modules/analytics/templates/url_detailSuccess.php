<?php use_helper('YiidUrl'); ?>
<?php slot('content') ?>
<div id="analytics-bread">
	<?php echo link_to(__('Dashboard'), 'analytics/index'); ?>&nbsp;&raquo;&nbsp;
	<?php echo link_to('Overview for '.$pDomainProfile->getUrl(), 'analytics/domain_statistics?domainid='.$pDomainProfile->getId()); ?>&nbsp;&raquo;&nbsp;
	<?php echo range_sensitive_link_to('Details for '.$pDomainProfile->getUrl(), 'analytics/domain_detail?domainid='.$pDomainProfile->getId());?>&nbsp;&raquo;&nbsp;
	<strong><?php echo range_sensitive_link_to('Details for '.$pUrl, 'analytics/url_detail', array('query_string' => 'url='.$pUrl.'&domainid='.$pDomainProfile->getId())); ?></strong>
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
      <option value="7" <?php echo ($selector == '7') ? 'selected="selected"':""; ?>><?php echo __('Last week'); ?></option>
      <option value="30" <?php echo ($selector == '30') ? 'selected="selected"':""; ?>><?php echo __('Last month'); ?></option>
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