<?php use_helper('ChartData') ?>
<?php
  $lDomainProfile = DomainProfileTable::getInstance()->find('3');
	$pData = MongoUtils::getActivityData($lDomainProfile->getUrl(), $pFrom, $pTo, 'daily');
	$lRawData = getChartLineActivitiesDataAsArray($pData, 'all');
	$lLikes = 0;
	$lDislikes = 0;
	foreach ($lRawData['likes'] as $key=>$value){
		$lLikes = $lLikes+$value;
	}

	foreach ($lRawData['dislikes'] as $key=>$value){
		$lDislikes = $lDislikes+$value;
	}

	$lAll = $lDislikes+$lLikes;
	$lDisRatio = round(100/$lAll*$lDislikes,2);
?>
<h2><?php echo __('%community% likes (and dislikes)', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_activities', array('pData' => $pData))?>
</div>


<h2><?php echo __('%community% key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Total values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes', array('%likes%' => $lLikes)); ?></li>
				<li><?php echo __('%dislikes% Dislikes', array('%dislikes%' => $lDislikes)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Mean values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes / Day', array('%likes%' => 1786)); ?></li>
				<li><?php echo __('%dislikes% Dislikes / Day', array('%dislikes%' => 23)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Percentage'); ?></h3>
			<ul>
				<li><?php echo __('%likes%% Dislike / Like Ratio', array('%likes%' => $lDisRatio)); ?></li>
				<li><?php echo __('%dislikes%% Clickback / Like Ratio', array('%dislikes%' => 197)); ?></li>
			</ul>
		</li>
	</ul>
</div>