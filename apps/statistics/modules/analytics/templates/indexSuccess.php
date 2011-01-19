<?php include_partial('analytics/filter', array('pVerifiedDomains' => $pVerifiedDomains, 'pHostId' => $pHostId, 'pAggregation' => $pAggregation, 'pDateFrom' => $pDateFrom, 'pDateTo' => $pDateTo)) ?>

<div class="content-box small-box" id="analytix-filter-nav-box">
	<?php include_component('analytics', 'filter_nav'); ?>
</div>

<div class="content-box left" id="analytix-content-box" style="width: 720px;">
	<?php include_partial('analytics/url_content', array('pCom' => 'all', 'pFrom' => $pDateFrom, 'pTo' => $pDateTo, 'pChart' => null, 'pUrl' => $pUrl)); ?>
</div>