<?php use_helper('ChartData') ?>
<h2><?php echo __('%community% likes (and dislikes)', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_activities', array('pData' => $pData))?>
</div>


<h2><?php echo __('%community% key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Total values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes', array('%likes%' => $pData['statistics']['total'][$pCom]['likes'])); ?></li>
				<li><?php echo __('%dislikes% Dislikes', array('%dislikes%' => $pData['statistics']['total'][$pCom]['dislikes'])); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => $pData['statistics']['total'][$pCom]['clickbacks'])); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Mean values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes / Day', array('%likes%' => $pData['statistics']['average'][$pCom]['likes'])); ?></li>
				<li><?php echo __('%dislikes% Dislikes / Day', array('%dislikes%' => $pData['statistics']['average'][$pCom]['dislikes'])); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => $pData['statistics']['average'][$pCom]['clickbacks'])); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Percentage'); ?></h3>
			<ul>
				<li><?php echo __('%likes%% Dislike / Like Ratio', array('%likes%' => $pData['statistics']['ratio'][$pCom]['dislike_like'])); ?></li>
				<li><?php echo __('%dislikes%% Clickback / Like Ratio', array('%dislikes%' => $pData['statistics']['ratio'][$pCom]['clickback_like'])); ?></li>
			</ul>
		</li>
	</ul>
</div>