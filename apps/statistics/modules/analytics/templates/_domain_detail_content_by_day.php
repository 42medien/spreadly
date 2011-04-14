<?php slot('content') ?>
<div id="line-chart-example">
<?php //include_partial('analytics/chart_line_example'); ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php slot('content') ?>
<div class="data-tablebox two-line-table">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
  <thead>
    <tr>
      <th width="280" height="32" align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('Top-URLs Overall'); ?></div></th>
      <th width="48" align="center" valign="middle"><div class="sortlink"><?php echo __('Likes');?></div></th>
      <th width="73" align="center" valign="middle"><div class="sortlink"><?php echo __('Spreads');?></div></th>
      <th width="78" align="center" valign="middle"><div class="sortlink"><?php echo __('Reach');?></div></th>
      <th width="79" align="center" valign="middle"><div class="sortlink"><?php echo __('Clickbacks');?></div></th>
      <th width="79" align="center" valign="middle" class="last"><div class="sortlink"><?php echo __('Clickback-Likes');?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($pUrls as $url){ ?>
      <tr>
        <td height="44" align="left" class="first" style="line-height: 21px;">
          <div class="martext">
            <?php if($url->getTitle() && $url->getTitle()!='') { ?>
              <strong><?php echo truncate_text($url->getTitle(), 60); ?></strong>
            <?php } else {?>
              <strong><?php echo __('No title'); ?></strong>
            <?php } ?>
              <br />
              <?php echo $url->getUrl(); ?>
          </div>
        </td>
        <td align="center"><div><?php echo $url->getLikes() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getShares() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getMediaPenetration() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getClickbacks() ?></div></td>
        <td align="center" class="last"><div><?php echo $url->getClickbackLikes() ?></div></td>
      </tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
<div id="demo-pie-charts" class="clearfix">
	<div class="alignleft">
		<?php include_partial('analytics/chart_pie_example', array('pChartsettings' =>
					'{
								"width": 300,
								"height": 130,
								"margin": [ 0, 0, 10, 40],
								"plotsize": "40%",
								"bgcolor" : "#e1e1e1",
								"renderto":"demo-pie-charts"
						}'
		)); ?>
	</div>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php if(count($pDeals) > 0) { ?>
<?php slot('content') ?>
	<?php include_partial('analytics/deal_table', array('pDeals' => $pDeals)); ?>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>