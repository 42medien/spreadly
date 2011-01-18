<h2><?php echo __('Likes and Dislikes for %url%', array('%url%' => $pUrl)); ?></h2>
<div class="content-box bg-white">
	<?php include_component('analytics', 'chart_line_url_details')?>
</div>

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
<?php include_component('analytics','url_table', array('pCom' => $pCom, 'pFrom' => $pFrom, 'pTo' => $pTo, 'pChart' => null)); ?>