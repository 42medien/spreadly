	<h2><?php echo __('Gender distribution'); ?></h2>
	<div class="content-box bg-white">
		<?php include_component('analytics','chart_pie_gender_activities', array('pChartsettings' =>
		'{
				"width": 450,
				"height": 230,
				"margin": [0, 0, 30, 160],
				"plotsize": "80%"
			}'
		)); ?>
	</div>

<h2><?php echo __('Demograhic key data', array('%community%' => $pCom)); ?><?php echo __(' from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left" id="demo-key-data-box">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Gender distribution'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% male', array('%percent%' => 64)); ?></li>
				<li><?php echo __('%percent%% female', array('%percent%' => 35)); ?></li>
				<li><?php echo __('%percent%% unknown', array('%percent%' => 1)); ?></li>
			</ul>
		</li>
		<li><h3><?php echo __('Average age'); ?></h3>
			<ul>
				<li><?php echo __('%age% years', array('%age%' => 23)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white two-third-box left">
	<ul class="analytics-stats-list left">
		<li><h3><?php echo __('Relationship'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% open', array('%percent%' => 0,12)); ?></li>
				<li><?php echo __('%percent%% engaged', array('%percent%' => 16)); ?></li>
				<li><?php echo __('%percent%% married', array('%percent%' => 27)); ?></li>
				<li><?php echo __('%percent%% complicated', array('%percent%' => 11)); ?></li>
				<li><?php echo __('%percent%% widowed', array('%percent%' => 3)); ?></li>
			</ul>
		</li>
	</ul>
	<?php include_component('analytics','chart_pie_relationship', array('pChartsettings' =>
		'{
				"width": 300,
				"height": 130,
				"margin": [ 0, 0, 10, 0],
				"plotsize": "40%"
			}'
		)); ?>
</div>

<div class="content-box bg-white two-third-box left">
	<ul class="analytics-stats-list left">
		<li><h3><?php echo __('Age distribution'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% under 18', array('%percent%' => 11)); ?></li>
				<li><?php echo __('%percent%% 18 to 24', array('%percent%' => 43)); ?></li>
				<li><?php echo __('%percent%% 25 to 34', array('%percent%' => 27)); ?></li>
				<li><?php echo __('%percent%% 35 to 54', array('%percent%' => 12)); ?></li>
				<li><?php echo __('%percent%% over 55', array('%percent%' => 7)); ?></li>
			</ul>
		</li>
	</ul>
	<?php include_component('analytics', 'chart_pie_relationship', array('pChartsettings' =>
		'{
				"width": 300,
				"height": 130,
				"margin": [ 0, 0, 10, 0],
				"plotsize": "40%"
			}'
		)); ?>
</div>
