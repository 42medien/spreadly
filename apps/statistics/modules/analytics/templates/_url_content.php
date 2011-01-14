<h2><?php echo __('Number of URLs shared via %community%', array('%community%' => $pCom)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_activities')?>
</div>

<h2><?php echo __('%community% key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Total values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% URLs with Likes', array('%likes%' => 1786)); ?></li>
				<li><?php echo __('%dislikes% URLs with Dislikes', array('%dislikes%' => 23)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white third-box left">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Mean values'); ?></h3>
			<ul>
				<li><?php echo __('%likes% Likes / URL', array('%likes%' => 1786)); ?></li>
				<li><?php echo __('%dislikes% Dislikes / URL', array('%dislikes%' => 23)); ?></li>
				<li><?php echo __('%clickbacks% Clickbacks / URL', array('%clickbacks%' => 88)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<?php include_component('analytics','url_table', array('pCom' => $pCom, 'pFrom' => $pFrom, 'pTo' => $pTo, 'pChart' => null)); ?>