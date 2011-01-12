<h2><?php echo __('Views on %community%', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_range_views'); ?>
</div>

<h2><?php echo __('Unique user on %community%', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_range_unique'); ?>
</div>

<h2><?php echo __('%community% range key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Total values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes', array('%likes%' => 1786)); ?></li>
				<li><?php echo __('%dislikes% Dislikes', array('%dislikes%' => 23)); ?></li>
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
				<li><?php echo __('%likes%% Dislike / Like Ratio', array('%likes%' => 0,12)); ?></li>
				<li><?php echo __('%dislikes%% Clickback / Like Ratio', array('%dislikes%' => 197)); ?></li>
			</ul>
		</li>
	</ul>
</div>