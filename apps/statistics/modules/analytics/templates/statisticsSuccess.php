<?php slot('content') ?>
<form name="analytics-filter-form" id="analytics-filter-form" action="<?php echo url_for('@get_analytics_content'); ?>">
<input type="hidden" name="type" value="<?php echo $pType ?>" />
	<?php if($pType == 'deal') { ?>
		<?php include_component('analytics', 'deal_filter') ?>
	<?php } else { ?>
		<?php include_component('analytics', 'url_filter') ?>
	<?php } ?>
</form>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>



<?php slot('content') ?>
<div id="analytics-content-box">
	<?php include_partial('analytics/'.$pType.'_content'); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>



<?php slot('content') ?>
<div id="analytics-table-box">
	<?php if($pType == 'deal') { ?>
		<?php include_partial('analytics/deal_table')?>
	<?php } elseif ($pType == 'domain') { ?>
		<?php include_partial('analytics/url_table')?>
	<?php } else { ?>
		<?php include_partial('analytics/like_table')?>
	<?php } ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

