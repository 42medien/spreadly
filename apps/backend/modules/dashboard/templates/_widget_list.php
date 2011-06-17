<div class="widget widget-single widget-one-section">
	<header><section><?php echo $title ?></section></header>
	<section class="widget-data-section">
		<ol class="widget-ordered-list">
		  <?php foreach ($items as $item): ?>
			<li class="small"><?php echo $item ?></li>
      <?php endforeach; ?>
		</ol>
	</section>
	<footer>
		Powered by @Spreadly
	</footer>
</div>
