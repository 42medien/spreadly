<?php use_helper('Text'); ?>
<?php
if ($pUrlSummary) {
  slot('content')
?>
<?php if (isset($showdate)) {?>
	<h2><?php echo __('Likes from %date%', array('%date%' => $showdate)); ?></h2>
<?php } ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities_by_hours', array("pData" => $pUrlSummary)); ?>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>

<?php slot('content') ?>
<h2><?php echo __('Like details for %url%', array('%url%' => $pUrlSummary->getUrl())); ?></h2>
<div class="data-tablebox two-line-table">
  <table width="930px;" border="0" cellspacing="0" cellpadding="0" id="top-like-table" class="tablesorter">
  <thead>
    <tr>
      <th align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('URLs'); ?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Age');?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Gender');?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Relationship');?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Spreads');?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Reach');?></div></th>
      <th align="center" valign="middle"><div class="sortlink"><?php echo __('Clickbacks');?></div></th>
      <th align="center" valign="middle" class="last"><div class="sortlink"><?php echo __('Clickback-Likes');?></div></th>
    </tr>
    </thead>
    <tbody>
    <?php
    if ($pUrls->hasNext()) {
      foreach($pUrls as $url){
    ?>
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
        <td align="center" valign="middle"><div><?php echo $url->getAge() ?></div></td>
        <td align="center" valign="middle"><div><?php echo __($url->getGender()) ?></div></td>
        <td align="center" valign="middle"><div><?php echo __($url->getRelationship()) ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getShares() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getMediaPenetration() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getClickbacks() ? $url->getClickbacks() : 0 ?></div></td>
        <td align="center" valign="middle" class="last"><div><?php echo $url->getClickbackLikes() ? $url->getClickbackLikes() : 0 ?></div></td>
      </tr>
    <?php
      }
    } else {
    ?>
      <tr><td align="center" colspan="8"><?php echo __("No likes yet"); ?></td></tr>
    <?php } ?>
    </tbody>
  </table>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php
if ($pUrlSummary) {
  slot('content');
?>
<h2><?php echo __('Demographics for %url%', array('%url%' => $pUrlSummary->getUrl())); ?></h2>
<div id="pie-charts" class="clearfix">
  <div class="alignleft" id="gender-chart">
    <?php include_partial('analytics/chart_pie_gender', array('pChartsettings' =>
          '{
                "width": 305,
                "height": 180,
                "margin": [ 40, 0, 10, 10],
                "plotsize": "50%",
                "bgcolor" : "#e1e1e1",
                "renderto":"gender-chart"
            }', 'pData' => $pUrlSummary->getDemographics()
    )); ?>
  </div>
  <div class="alignleft" id="age-chart">
    <?php include_partial('analytics/chart_pie_age', array('pChartsettings' =>
          '{
                "width": 305,
                "height": 180,
                "margin": [ 40, 20, 10, 20],
                "plotsize": "50%",
                "bgcolor" : "#e1e1e1",
                "renderto":"age-chart"
            }', 'pData' => $pUrlSummary->getDemographics()
    )); ?>
  </div>
  <div class="alignleft" id="relation-chart">
    <?php include_partial('analytics/chart_pie_relationship', array('pChartsettings' =>
          '{
                "width": 305,
                "height": 180,
                "margin": [ 40, 0, 10, 10],
                "plotsize": "50%",
                "bgcolor" : "#e1e1e1",
                "renderto":"relation-chart"
            }', 'pData' => $pUrlSummary->getDemographics()
    )); ?>
  </div>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>