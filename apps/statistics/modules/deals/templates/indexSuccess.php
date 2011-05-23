  <div id="create-deal-content">
		<?php include_partial('deals/create_index');?>
		<?php //include_partial('deals/deal_in_process', array('pIsNew' => false));?>
		<?php //include_component('deals', 'create_deal_form');?>
  </div>
	<div id="deal-table-box">
		<?php if($pDeals) { ?>
			<?php include_partial('deals/deal_table', array('pDeals' => $pDeals)); ?>
		<?php } ?>
	</div>

<div id="analytix-filter-nav-box" class="deal-analytix-filter-nav" style="display:none;">
	<?php //include_component('analytics', 'filter_nav'); ?>
</div>

<div id="analytix-content-box" class="deal-analytix-content" style="display:none;">
	<?php //include_partial('analytics/activities_content', array('pCom' => 'all', 'pFrom' => $pDateFrom, 'pTo' => $pDateTo, 'pChart' => null, 'pUrl' => $pUrl, 'pData' => $pData)); ?>
</div>