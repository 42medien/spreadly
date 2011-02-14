<?php include_partial('analytics/filter', array('pVerifiedDomains' => $pVerifiedDomains, 'pHostId' => $pHostId, 'pAggregation' => $pAggregation, 'pDateFrom' => $pDateFrom, 'pDateTo' => $pDateTo)) ?>

<div id="analytix-filter-nav-box">
	<?php include_component('analytics', 'filter_nav'); ?>
</div>


<div id="analytix-content-box">
	<?php include_partial('analytics/url_activities_content', array('pCom' => 'all', 'pFrom' => $pDateFrom, 'pTo' => $pDateTo, 'pUrl' => $pUrl, 'pData' => $pData)); ?>
</div>

