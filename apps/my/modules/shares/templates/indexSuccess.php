<?php use_helper("CustomTags"); ?>
<div class="page-header">
  <?php include_component("shares", "order_by"); ?>
  <h1>
    <?php
    if ($search = $sf_request->getParameter("s", null)) {
      echo __('Search results for "%s"', array("%s" => $search));
    } else {
      echo __("Your latest Likes");
    }
    ?>
    <small><?php echo $activities->getNbResults()." ".__("Results"); ?></small>
  </h1>
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
      <?php include_partial("share", array("activity" => $activity)); ?>
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
            <td><a rel="tooltip" title="<?php echo __("How many people have potentially seen this share."); ?>" href="#"><?php echo __("Reach") ?></a></td>
            <td><span class="badge badge-success"><?php echo $activity->getAnalyticsActivity()->getMediaPenetration(); ?></span></td>
          </tr>
          <tr>
            <td><a rel="tooltip" title="<?php echo __("How many people clicked on one of your shares."); ?>" href="#"><?php echo __("Clickbacks"); ?></a></td>
            <td><?php echo $activity->getCb()?$activity->getCb():0; ?></td>
          </tr>
          <tr>
            <td><a rel="tooltip" title="<?php echo __("To how many networks you have shared this link."); ?>" href="#"><?php echo __("Spreads"); ?></a></td>
            <td><?php echo $activity->getAnalyticsActivity()->getShares(); ?></td>
          </tr>
        </tbody>
      </table>
      <?php echo __("More %s stats", array("%s" => link_to($activity->getHost(), "@host_stats?id=".$activity->getSocialObject()->getId()))); ?>
    </div>
  </div>
  <hr />
<?php } ?>

<div class="row">
  <?php include_component("shares", "pager", array("pager" => $activities)); ?>
</div>