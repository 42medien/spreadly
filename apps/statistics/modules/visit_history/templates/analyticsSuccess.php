<?php use_helper('Date', 'DomainProfiles') ?>
<?php if($pVerifiedDomains==null || count($pVerifiedDomains)<=0): ?>
  <div class="content-header-box">
    <div class="content-box-head">
      <a class="button-green" href="/domain_profiles/index"><?php echo __('GO!');?></a>
      <h3><?php echo __('Claim Your Websites')?></h3>
    </div>
    <div class="content-box-body">
      <p><?php echo __('To keep access to your data secure, a couple of yiids features is only accessable after successfully claiming your ownership of your website.');?></p>
      <p><?php echo __('Yiid has a simplified process for that: we create a so called MicroId for you, which combines your domain and your email address into a unique key.');?></p>
      <p><?php echo __("You only have to copy & paste this MicroId meta tag into the <head> section of your homepage, kick off the verification process on yiid and you're done.");?></p>
      <p><?php echo __("In case of problems, please contact");?> <a href="mailto: info@yiid.com">info@yiid.com</a></p>
      <p><a class="button-green" href="/domain_profiles/index"><?php echo __('Claim Your Websites'); ?></a></p>
    </div>
  </div>
<?php else: ?>
  <?php echo include_partial('filter', array('pVerifiedDomains' => $pVerifiedDomains, 'pHostId' => $pHostId, 'pAggregation' => $pAggregation, 'pDateFrom' => $pDateFrom, 'pDateTo' => $pDateTo)) ?>
<div class="content-box">
    <h2 style="text-align: center;"><?php echo __('Networks Activities and Clickbacks'); ?></h2>
    <h2 style="text-align: center;"><?php echo __('Period'); ?>: <?php echo $pDateFrom; ?> <?php echo __('to');?> <?php echo $pDateTo; ?></h2>
    <?php echo __('Stacked chart showing positive (e.g. Likes, usually the tall columns) and negative (e.g. Dislikes, usually the low columns) reactions on your content coming from yiid buttons and browser extensions. Columns consist of the services you select. ClickBacks show the response coming from social recommendations measured during the same timeframe.'); ?>
    <?php echo include_component('visit_history','chart_column_activities_clickbacks'); ?>
  </div>
  <div class="content-box">
    <?php echo include_component('visit_history','chart_area_age_distribution'); ?>
    <?php echo include_component('visit_history','chart_pie_gender_activities'); ?>
    <?php echo include_component('visit_history','chart_pie_demographic_activities'); ?>
  </div>
  <div class="content-box">
    <h2 style="text-align: center;"><?php echo __('Media Penetration and Clickbacks'); ?></h2>
    <h2 style="text-align: center;"><?php echo __('Period'); ?>: <?php echo $pDateFrom; ?> <?php echo __('to');?> <?php echo $pDateTo; ?></h2>
    <?php echo __('Stacked chart showing how many users you reach through likes (and dislikes) on the targeted networks. Linechart showing clickBacks: users you receive from seeing likes of friends that originate in recommending your content by using yiid buttons.'); ?>
    <?php echo include_component('visit_history','chart_column_mediapenetration_clickbacks'); ?>
  </div>
  <div class="content-box">
    <h2 style="text-align: center;"><?php echo __('Top 10 URLs'); ?></h2>
    <?php echo include_component('visit_history','table_top_activities'); ?>
  </div>
<?php endif; ?>
