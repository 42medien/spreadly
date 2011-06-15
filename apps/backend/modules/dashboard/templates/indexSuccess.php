<?php use_helper('Dashboard'); ?>

<section class="main-section number-section clearfix">
	<div class="widget widget-single">
		<header><section>This is now</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo date('H:i') ?>h</div>
		</section>
		<section class="widget-data-body">
			<div class="big"><?php echo date('l') ?></div>
			<div class="big"><?php echo date('d.m.Y') ?></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>

	<div class="widget widget-single widget-one-section">
		<header><section>spread.ly User</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo $data['current_user_count'] ?></div>
			<div class="bigger <?php echo upDownClass($data['user_count_delta']) ?>"><div class="<?php echo upDownClass($data['user_count_delta']) ?>-arrow-small left">&nbsp;</div><?php echo absOrInfinity($data['user_count_delta']) ?><small>&nbsp;%</small></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>

	<div class="widget widget-single widget-one-section">
		<header><section>spreadly.com User</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo $data['current_stats_user_count'] ?></div>
			<div class="bigger <?php echo upDownClass($data['stats_user_count_delta']) ?>"><div class="<?php echo upDownClass($data['stats_user_count_delta']) ?>-arrow-small left">&nbsp;</div><?php echo absOrInfinity($data['stats_user_count_delta']) ?><small>&nbsp;%</small></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>

	<div class="widget widget-single widget-one-section">
		<header><section>Likes</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo $data['current_likes_count'] ?></div>
			<div class="bigger <?php echo upDownClass($data['likes_count_delta']) ?>"><div class="<?php echo upDownClass($data['likes_count_delta']) ?>-arrow-small left">&nbsp;</div><?php echo absOrInfinity($data['likes_count_delta']) ?><small>&nbsp;%</small></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>
	
	<div class="widget widget-single widget-one-section">
		<header><section>Domains claimed</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo $data['current_domain_count'] ?></div>
			<div class="bigger <?php echo upDownClass($data['domain_count_delta']) ?>"><div class="<?php echo upDownClass($data['domain_count_delta']) ?>-arrow-small left">&nbsp;</div><?php echo absOrInfinity($data['domain_count_delta']) ?><small>&nbsp;%</small></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>

	<div class="widget widget-single widget-one-section">
		<header><section>Domains verified</section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo $data['current_verified_domain_count'] ?></div>
			<div class="bigger <?php echo upDownClass($data['verified_domain_count_delta']) ?>"><div class="<?php echo upDownClass($data['verified_domain_count_delta']) ?>-arrow-small left">&nbsp;</div><?php echo absOrInfinity($data['verified_domain_count_delta']) ?><small>&nbsp;%</small></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>
</section>

<section class="main-section chart-section clearfix">
	<div class="widget widget-single large" style="text-align: center;"><h3>Spreadly</h3><div class="large">1350</div><div class="big">5%</div></div>
	<div class="widget widget-single">2</div>
	<div class="widget widget-single">3</div>
	<div class="widget widget-single">4</div>
	<div class="widget widget-double">5</div>
	<div class="widget widget-single">6</div>
</section>
<section class="main-section table-section clearfix">
	<div class="widget widget-single large" style="text-align: center;"><h3>Spreadly</h3><div class="large">1350</div><div class="big">5%</div></div>
	<div class="widget widget-single">2</div>
	<div class="widget widget-single">3</div>
	<div class="widget widget-single">4</div>
	<div class="widget widget-double">5</div>
	<div class="widget widget-single">6</div>
</section>
