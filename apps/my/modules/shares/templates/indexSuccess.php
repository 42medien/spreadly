<div class="page-header">
  <h1><?php echo __("Your latest Shares"); ?></h1>
</div>

<input type="text" class="typeahead" id="typeahead" data-provide="typeahead" />

<?php foreach ($activities->getResults() as $activity) { ?>
  <div class="row">
    <div class="span2">
      <div class="thumbnail"><img src="<?php echo $activity->getThumb(); ?>" /></div>
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
        <p><i class="icon-tags"></i> <?php echo implode(", ", $activity->getTags()->getRawValue()); ?></p>
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
            <td><?php echo __("Shares"); ?> <small><?php echo __("(different networks)"); ?></small></td>
            <td><?php echo $activity->getAnalyticsActivity()->getShares(); ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
  <hr />
<?php } ?>

<?php include_partial("shares/pager", array("pager" => $activities)); ?>