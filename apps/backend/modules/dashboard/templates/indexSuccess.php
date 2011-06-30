<?php use_helper('Dashboard', 'Text'); ?>

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
  <?php include_partial('widget_single_without_delta', array('title' => 'Spread.ly Visitors', 'data' => $data, 'type' => 'popup_visitors', 'powered_by' => 'Chartbeat')) ?>
  <?php include_partial('widget_single', array('title' => 'spreadly.com User', 'data' => $data, 'type' => 'stats_user')) ?>
  <?php include_partial('widget_single_with_conversion', array('title' => 'Likes & Deals', 'data' => $data, 'type' => 'likes', 'range' => $range)) ?>
  <?php include_partial('widget_single', array('title' => 'Domains claimed', 'data' => $data, 'type' => 'domain')) ?>

  <?php include_partial('widget_single', array('title' => 'Domains verified', 'data' => $data, 'type' => 'verified_domain')) ?>
	<?php include_partial('widget_single', array('title' => 'Media penetration', 'data' => $data, 'type' => 'media_penetration')) ?>
	<?php include_partial('widget_single', array('title' => 'Clickbacks', 'data' => $data, 'type' => 'clickback')) ?>
	<?php include_partial('widget_single', array('title' => 'Clickback-Likes', 'data' => $data, 'type' => 'cbl')) ?>
</section>
<section class="main-section chart-section clearfix">
	<?php include_partial('widget_linechart', array('title' => 'Likes', 'data' => $data, 'type' => 'likes', 'range' => $range)) ?>

	<?php include_partial('widget_linechart', array('title' => 'Deals', 'data' => $data, 'type' => 'deals', 'range' => $range)) ?>

	<?php include_partial('widget_piechart', array('title' => 'Services', 'data' => $data, 'type' => 'services')) ?>
</section>
<section class="main-section list-section clearfix">
  <div class="widget widget-single widget-one-section">
  	<header><section>Powerliker</section></header>
  	<section class="widget-data-section">
  		<ol class="widget-ordered-list" style="list-style-type: none;">
  		  <?php foreach ($data['top_users'] as $item): ?>
  			<li class="small" style="margin: 0 0 5px 0;"><img style="vertical-align: middle; margin-right: 5px; max-height: 16px; max-width: 16px;" src="<?php echo UserTable::getInstance()->find($item['u_id'])->getAvatar() ?>" /> <?php echo UserTable::getInstance()->find($item['u_id'])->getFullname() ?> (<?php echo $item['count'] ?>)</li>
        <?php endforeach; ?>
  		</ol>
  	</section>
  	<footer>
  		Powered by @Spreadly
  	</footer>
  </div>


  <div class="widget widget-single widget-one-section widget-double">
  	<header><section>Top Hosts</section></header>
  	<section class="widget-data-section">
  		<ol class="widget-ordered-list">
  		  <?php foreach ($data['top_hosts'] as $item): ?>
  			<li class="small" title="<?php echo $item['host'] ?> (<?php echo $item['count'] ?>)"><a href="http://<?php echo $item['host'] ?>" title="<?php echo $item['host'] ?>" target="_blank"><?php echo $item['host'] ?></a> (<?php echo $item['count'] ?>)</li>
        <?php endforeach; ?>
  		</ol>
  	</section>
  	<footer>
  		Powered by @Spreadly
  	</footer>
  </div>

  <div class="widget widget-single widget-one-section widget-double">
  	<header><section>Top URLs</section></header>
  	<section class="widget-data-section">
  		<ol class="widget-ordered-list">
  		  <?php foreach ($data['top_urls'] as $item): ?>
  			<li class="small" title="<?php echo $item['url'] ?> (<?php echo $item['count'] ?>)"><a href="<?php echo $item['url'] ?>" title="<?php echo $item['url'] ?>" target="_blank"><?php echo truncate_text($item['url'], 40); ?></a> (<?php echo $item['count'] ?>)</li>
        <?php endforeach; ?>
  		</ol>
  	</section>
  	<footer>
  		Powered by @Spreadly
  	</footer>
  </div>
</section>


