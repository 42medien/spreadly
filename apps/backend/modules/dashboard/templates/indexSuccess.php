<?php use_helper('Dashboard'); ?>

<section class="main-section number-section clearfix">
	<div class="widget widget-single">
		<header><section><?php echo $range ?></section></header>
		<section class="widget-data-section">
			<div class="large"><?php echo date('H:i') ?>h</div>
		</section>
		<section class="widget-data-body">
			<div class="big"><?php echo $fromDate ?></div>
			<?php if($range == 'last7d' || $range == 'last30d'): ?>
			  <center style="line-height: 0.5em">&mdash;</center>
			<?php endif; ?>
			<div class="big"><?php echo $toDate ?></div>
		</section>
		<footer>
			Powered by @Spreadly
		</footer>
	</div>

  <?php include_partial('widget_single', array('title' => 'spread.ly User', 'data' => $data, 'type' => 'user')) ?>
  <?php include_partial('widget_single', array('title' => 'spreadly.com User', 'data' => $data, 'type' => 'stats_user')) ?>
  <?php include_partial('widget_single', array('title' => 'All Likes', 'data' => $data, 'type' => 'likes')) ?>
  <?php include_partial('widget_single', array('title' => 'Domains claimed', 'data' => $data, 'type' => 'domain')) ?>
  <?php include_partial('widget_single', array('title' => 'Domains verified', 'data' => $data, 'type' => 'verified_domain')) ?>
	<?php include_partial('widget_single', array('title' => 'Media penetration', 'data' => $data, 'type' => 'media_penetration')) ?>
	<?php include_partial('widget_single', array('title' => 'Clickbacks', 'data' => $data, 'type' => 'clickback')) ?>

  <?php include_partial('widget_piechart', array('title' => 'Services', 'data' => $data, 'type' => 'services')) ?>
	<?php include_partial('widget_linechart', array('title' => 'Domains verified', 'data' => $data, 'type' => 'verified_domain')) ?>

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
