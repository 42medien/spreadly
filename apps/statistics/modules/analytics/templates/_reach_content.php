<h2><?php echo __('Views on %community%', array('%community%' => $pCom)); ?></h2>
<?php //var_dump($pData['statistics']['ratio']);die();?>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_range_views', array('pData' => $pData)); ?>
	<?php //var_dump($pData['statistics']);die();?>
</div>

<h2><?php echo __('%community% range key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Your activities (likes + dislikes) had...'); ?></h3>
			<ul>
				<li><?php echo __('%views% Views', array('%views%' => $pData['statistics']['total'][$pCom]['contacts'])); ?></li>
				<li><?php echo __('%likes% Likes', array('%likes%' => $pData['statistics']['total'][$pCom]['likes'])); ?></li>
				<li><?php echo __('%dislikes% Dislikes', array('%dislikes%' => $pData['statistics']['total'][$pCom]['dislikes'])); ?></li>

			</ul>
		</li>
		<li><h3><?php echo __('The response on these views was...'); ?></h3>
			<ul>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => $pData['statistics']['total'][$pCom]['clickbacks'])); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Mean values'); ?></h3>
			<ul>
				<li><?php echo __('%views% Views / Activity', array('%views%' => $pData['statistics']['ratio'][$pCom]['contacts_activities'])); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => $pData['statistics']['average'][$pCom]['clickbacks'])); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Percentage'); ?></h3>
			<ul>
				<li><?php echo __('%likes%% Likes, %dislikes%% Dislikes', array('%likes%' => $pData['statistics']['ratio'][$pCom]['like_percentage'], '%dislikes%' => $pData['statistics']['ratio'][$pCom]['dislike_percentage'])); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks per 100 Activities', array('%clickbacks%' => $pData['statistics']['ratio'][$pCom]['clickback_activities'])); ?></li>
			</ul>
		</li>
	</ul>
</div>