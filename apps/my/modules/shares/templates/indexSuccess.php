<?php use_helper("CustomTags"); ?>
<div class="page-header">
  <?php include_component("shares", "order_by"); ?>
  <h1><?php echo __("Your latest Likes"); ?> <small><?php echo $activities->getNbResults()." ".__("Results"); ?></small></h1>
</div>

<div class="row">
  <?php include_component("shares", "pager", array("pager" => $activities)); ?>
</div>

<hr />

<?php foreach ($activities->getResults() as $activity) { ?>
  <div class="row">
    <div class="span2">
      <?php if ($activity->getThumb()) { ?>
      <div class="thumbnail"><img src="<?php echo $activity->getThumb(); ?>" /></div>
      <?php } else { ?>
      &nbsp;
      <?php } ?>
    </div>
    <div class="span7">
      <h2><?php echo $activity->getTitle(); ?></h2>
      <p><strong><?php echo $activity->getDescr(); ?></strong></p>
      <?php if ($activity->getComment()) { ?>
        <p><i class="icon-comment"></i> <?php echo $activity->getComment(); ?></p>
      <?php } ?>
      <p><i class="icon-time"></i> <?php echo date("d.m.Y / H:i", $activity->getC()); ?></p>
      <p><i class="icon-external-link"></i> <?php echo link_to($activity->getUrl(), $activity->getUrl(), array("target" => "_blank")); ?></p>
      <?php if ($activity->getTags()) { ?>
        <i class="icon-tags"></i> <?php echo simple_tag_list($activity->getTags(), array("separator" => ","), "shares/index?t="); ?>
      <?php } ?>
    </div>
    <div class="span3">
      <table class="table table-bordered table-striped table-condensed">
        <thead>
          <tr>
            <th><i class="icon-bar-chart"></i> Stats</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td><?php echo __("Reach") ?></td>
            <td><span class="badge badge-success"><?php echo $activity->getAnalyticsActivity()->getMediaPenetration(); ?></span></td>
          </tr>
          <tr>
            <td><?php echo __("Clickbacks"); ?></td>
            <td><?php echo $activity->getCb()?$activity->getCb():0; ?></td>
          </tr>
          <tr>
            <td><?php echo __("Spreads"); ?> <small><?php echo __("(different networks)"); ?></small></td>
            <td><?php echo $activity->getAnalyticsActivity()->getShares(); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <hr />
<?php } ?>

<div class="row">
  <?php include_component("shares", "pager", array("pager" => $activities)); ?>
</div>