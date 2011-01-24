<h2><?php echo __('Views on %community%', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_range_views'); ?>
</div>

<h2><?php echo __('%community% range key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Total values for Likes'); ?></h3>
			<ul>
				<li><?php echo __('%views% Views', array('%views%' => 1786)); ?></li>
				<li><?php echo __('%dislikes% Dislikes', array('%dislikes%' => 23)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
		<li><h3><?php echo __('Total values for Dislikes'); ?></h3>
			<ul>
				<li><?php echo __('%views% Views', array('%views%' => 1786)); ?></li>
			</ul>
		</li>
		<li><h3><?php echo __('Responses'); ?></h3>
			<ul>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => 1786)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Mean values'); ?></h3>
			<ul>
				<li><?php echo __('%views% Views / Like', array('%views%' => 1786)); ?></li>
				<li><?php echo __('%views% Views / Dislike', array('%views%' => 1786)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Percentage'); ?></h3>
			<ul>
				<li><?php echo __('%likes%% Likes, %dislikes%% Dislikes', array('%likes%' => 99, '%dislikes%' => 1)); ?></li>
				<li><?php echo __('%clickbacks%% Clickbacks per 100 Likes', array('%clickbacks%' => 2)); ?></li>
			</ul>
		</li>
	</ul>
</div>