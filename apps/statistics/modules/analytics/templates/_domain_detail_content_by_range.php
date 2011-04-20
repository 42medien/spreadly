<?php
if ($pHostSummary) {
  slot('content')
?>
<div id="line-chart-example">
<?php include_partial('analytics/chart_line_activities', 
        array(
          "pData" => $pLikes, 
          'pFromYear' => date('Y', strtotime($pStartDay)),
          'pFromMonth' => date('m', strtotime($pStartDay)),
          'pFromDay' => date('d', strtotime($pStartDay))
        )
      ); ?>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}
?>

<?php slot('content') ?>
<div class="data-tablebox two-line-table">
  <table width="100%" border="0" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
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
              <?php echo link_to($url->getUrl(), 'analytics/url_detail', array('query_string' => 'domainid='.$pDomainProfile->getId().'&url='.urlencode($url->getUrl()))); ?>
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
      <tr><td align="center" colspan="6"><?php echo __("No likes yet"); ?></td></tr>
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
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
            }', 'pData' => $pHostSummary[$pDomainProfile->getUrl()]['value']['d']
    )); ?>
  </div>
</div>
<?php
  end_slot();
  include_partial('global/graybox');
}

slot('content');
  include_component('analytics', 'active_deal_table', array("host" => $pDomainProfile->getUrl()));
end_slot();
include_partial('global/graybox');
?>