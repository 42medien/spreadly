<?php
use_helper('Text');
if ($pHostSummary) {
  slot('content')
?>
<?php if (isset($showdate)) {?>
	<h2 class="sub_title"><?php echo __('Likes from %date%', array('%date%' => $showdate)); ?></h2>
<?php } ?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities_by_hours', array("pData" => $pHostSummary)); ?>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>
<?php slot('content') ?>
<h2 class="sub_title"><?php echo __('URL overview'); ?></h2>
<div class="data-tablebox two-line-table">
  <table cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter" width="930px;">
  <thead>
    <tr>
      <th width="280" height="32" align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('Top-URLs'); ?></div></th>
      <th width="48" align="center" valign="middle"><div class="sortlink"><?php echo __('Likes');?></div></th>
      <th width="73" align="center" valign="middle"><div class="sortlink"><?php echo __('Spreads');?></div></th>
      <th width="78" align="center" valign="middle"><div class="sortlink"><?php echo __('Reach');?></div></th>
      <th width="79" align="center" valign="middle"><div class="sortlink"><?php echo __('Clickbacks');?></div></th>
      <th width="79" align="center" valign="middle" class="last"><div class="sortlink"><?php echo __('Clickback-Likes');?></div></th>
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
              <?php echo link_to(truncate_text($url->getUrl(), 60), 'analytics/url_detail', array('query_string' => 'domainid='.$pDomainProfile->getId().'&url='.urlencode($url->getUrl()))); ?>
          </div>
        </td>
        <td align="center"><div><?php echo $url->getLikes() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getShares() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getMediaPenetration() ?></div></td>
        <td align="center" valign="middle"><div><?php echo $url->getClickbacks() ?></div></td>
        <td align="center" class="last"><div><?php echo $url->getClickbackLikes() ?></div></td>
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
if ($pHostSummary) {
  slot('content');
?>
<h2 class="sub_title"><?php echo __('Demographic overview'); ?></h2>
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
            }', 'pData' => $pHostSummary->getDemographics()
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
            }', 'pData' => $pHostSummary->getDemographics()
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
            }', 'pData' => $pHostSummary->getDemographics()
    )); ?>
  </div>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}

slot('content');
?>
<h2 class="sub_title"><?php echo __('Deal overview'); ?></h2>
<?php
  include_component('analytics', 'active_deal_table', array("host" => $pDomainProfile->getUrl()));
end_slot();
include_partial('global/graybox');
?>