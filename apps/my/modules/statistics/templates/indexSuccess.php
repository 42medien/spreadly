<?php use_helper("CustomTags"); ?>
<div class="page-header">
  <h1><?php echo __("How big is your penis?"); ?></h1>
</div>

<div class="hero-unit">
  <div class="row">
    <div class="span3">
      <h2><i class="icon-share"></i> <?php echo __("Shares"); ?></h2>
      <p><?php echo $shares_complete; ?></p>
    </div>
    <div class="span3">
      <h2><i class="icon-share-alt"></i> <?php echo __("Clickbacks"); ?></h2>
      <p><?php echo $clickbacks_complete; ?></p>
    </div>
    <div class="span3">
      <h2><i class="icon-bar-chart"></i> <?php echo __("Spread Rank"); ?></h2>
      <p>
        <div class="progress">
          <div class="bar" style="width: 60%;"></div>
        </div>

        60/100
      </p>
    </div>
  </div>
</div>

<div class="row">
  <div class="span4">
    <h2><?php echo __("Tags"); ?> <small>(<?php echo __("the overall Top-100 tags"); ?>)</small></h2>
    <?php echo simple_tag_cloud($tags); ?>
  </div>
  <div class="span8">
    <h2><?php echo __("Top Spreads"); ?> <small>(<?php echo __("the overall Top-20 shares"); ?>)</small></h2>
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><?php echo __("Link"); ?></th>
          <th><?php echo __("Date"); ?></th>
          <th><?php echo __("Clickbacks"); ?></th>
          <th><?php echo __("Top Network"); ?></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach($activities as $activity) { ?>
        <tr>
          <td><?php echo $activity->getUrl(); ?></td>
          <td><?php echo $activity->getDate()->format( 'd.m.Y' ); ?></td>
          <td><?php echo $activity->getClickbacks(); ?></td>
          <td><?php echo $activity->getNetworkWithMostClickbacks(); ?></td>
        </tr>
      <?php } ?>
      </tbody>
    </table>
  </div>
</div>