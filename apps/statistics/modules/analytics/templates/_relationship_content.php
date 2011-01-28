	<h2><?php echo __('Relationship status'); ?></h2>
	<div class="content-box bg-white">
		<?php include_partial('analytics/chart_pie_relationship', array('pChartsettings' =>
		'{
				"width": 450,
				"height": 230,
				"margin": [20, 0, 30, 160],
				"plotsize": "80%"
			}', 'pData' => $pData
		)); ?>
	</div>

<h2><?php echo __('Demograhic key data', array('%community%' => $pCom)); ?><?php echo __(' from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
<div class="content-box bg-white third-box left" id="demo-key-data-box">
	<ul class="analytics-stats-list">
		<li><h3><?php echo __('Gender distribution'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% open', array('%percent%' => 11)); ?></li>
				<li><?php echo __('%percent%% engaged', array('%percent%' => 43)); ?></li>
				<li><?php echo __('%percent%% married', array('%percent%' => 27)); ?></li>
				<li><?php echo __('%percent%% complicated', array('%percent%' => 12)); ?></li>
				<li><?php echo __('%percent%% widowed', array('%percent%' => 7)); ?></li>
			</ul>
		</li>
	</ul>
</div>
<div class="content-box bg-white two-third-box left">
	<ul class="analytics-stats-list left">
		<li><h3><?php echo __('Age distribution'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% under 18', array('%percent%' => $pData["statistics"]["ratio"]["age"]["u_18"])); ?></li>
				<li><?php echo __('%percent%% 18 to 24', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_18_24"])); ?></li>
				<li><?php echo __('%percent%% 25 to 34', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_25_34"])); ?></li>
				<li><?php echo __('%percent%% 35 to 54', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_35_54"])); ?></li>
				<li><?php echo __('%percent%% over 55', array('%percent%' => $pData["statistics"]["ratio"]["age"]["o_55"])); ?></li>
			</ul>
		</li>
	</ul>
	<?php include_partial('analytics/chart_pie_age_activities', array('pChartsettings' =>
		'{
				"width": 330,
				"height": 130,
				"margin": [25, 0, 30, 30],
				"spacingRight": 0
			}', 'pData' => $pData
		)); ?>
</div>

<div class="content-box bg-white two-third-box left">
	<ul class="analytics-stats-list left">
		<li><h3><?php echo __('Gender distribution'); ?></h3>
			<ul>
				<li><?php echo __('%percent%% male', array('%percent%' => 64)); ?></li>
				<li><?php echo __('%percent%% female', array('%percent%' => 35)); ?></li>
				<li><?php echo __('%percent%% unknown', array('%percent%' => 1)); ?></li>
			</ul>
		</li>
	</ul>
		<?php include_partial('analytics/chart_pie_gender_activities', array('pChartsettings' =>
		'{
				"width": 300,
				"height": 130,
				"margin": [-40, 0, 10, 0],
				"plotsize": "40%"
			}', 'pData' => $pData
		)); ?>
</div>


