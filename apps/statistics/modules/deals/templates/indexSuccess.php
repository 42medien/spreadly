<!--  div id="main_area_navigation" class="clearfix">
	<ul class="clearfix">
    <li><?php //echo __('Create Deal'); ?></li>
    <li class="main_navigation active"><a class="nav-tab" href="deals/create_deal_form">&raquo; <?php echo __('Step 1/2: Set Your Deal Data'); ?></a></li>
  	<li class="main_navigation active hide"><a class="nav-tab" href="deals/get_code_form">&raquo; <?php echo __('Step 2/2: Confirm Deal and Get Code'); ?></a></li>
	</ul>
</div -->
  <div id="create-deal-content">
		<?php include_partial('deals/create_index');?>
		<?php //include_partial('deals/deal_in_process', array('pIsNew' => false));?>
		<?php include_component('deals', 'create_deal_form');?>
  </div>
	<div class="content-box" id="deal-table-box">
		<?php if($pDeals) { ?>
			<?php include_partial('deals/deal_table', array('pDeals' => $pDeals)); ?>
		<?php } ?>
	</div>

<div class="content-box small-box" id="analytix-filter-nav-box" style="display:none;">
	<?php //include_component('analytics', 'filter_nav'); ?>
</div>

<div class="content-box left" id="analytix-content-box" style="width: 720px; display:none;">
	<?php //include_partial('analytics/activities_content', array('pCom' => 'all', 'pFrom' => $pDateFrom, 'pTo' => $pDateTo, 'pChart' => null, 'pUrl' => $pUrl, 'pData' => $pData)); ?>
</div>