<?php use_helper("CustomTags", "YiidNumber"); ?>
<div class="page-header">
  <h1>
    <?php echo parse_url($social_object->getUrl(), PHP_URL_HOST); ?>
    <small><?php echo __("First share"); ?>: <?php echo date("d.m.Y", $first_share["date"]->sec); ?> | <?php echo __("Last share"); ?>: <?php echo date("d.m.Y", $last_share["date"]->sec); ?></small>
  </h1>
</div>

<div class="hero-unit">
  <div class="row">
    <div class="span3">
      <h2><i class="icon-heart"></i> <?php echo __("Likes"); ?></h2>
      <p class="score"><?php echo point_format($host_summary->getLikes()); ?></p>
    </div>
    <div class="span3">
      <h2><i class="icon-share-alt"></i> <?php echo __("Clickbacks"); ?></h2>
      <p class="score"><?php echo point_format($host_summary->getClickbacks()); ?></p>
    </div>
    <div class="span4">
      <h2><i class="icon-group"></i> <?php echo __("Media Penetration"); ?></h2>
      <p class="score"><?php echo point_format($host_summary->getMediaPenetration()); ?></p>
    </div>
  </div>
</div>

<h2><?php echo __("Latest Shares"); ?></h2>
<hr />
<?php foreach($social_objects as $social_object) { ?>
  <?php $activity = $social_object->getLatestYiidActivity(); ?>
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
      <p><i class="icon-time"></i> <?php echo date("d.m.Y / H:i", $activity->getC()); ?></p>
      <p><i class="icon-external-link"></i> <?php echo link_to($activity->getUrl(), $activity->getUrl(), array("target" => "_blank")); ?></p>
      <?php if ($activity->getTags()) { ?>
        <i class="icon-tags"></i> <?php echo simple_tag_list($activity->getTags(), array("separator" => ","), "shares/index?t="); ?>
      <?php } ?>
    </div>
    <div class="span3">
      <h3>Who shared this site?</h3>
      
      <ul class="users">
      <?php foreach ($social_object->getUids() as $user_id) { ?>
        <?php if ($user = UserTable::getInstance()->find($user_id)) { ?>
        <li><?php echo image_tag($user->getAvatar(), array("title" => $user->getFullname(), "alt" => "Image of ".$user->getFullname())); ?></li>
        <?php } ?>
      <?php } ?>
      </ul>
    </div>
  </div>
  <hr />
<?php } ?>

<div class="row">
  <div class="span12">
    <h2><?php echo __("Most shared Sites:"); ?></h2>
    
    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><?php echo __("URL"); ?></th>
          <th><?php echo __("Likes"); ?></th>
          <th><?php echo __("Media Penetration"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($url_summarys as $summary) { ?>
        <tr>
          <td><?php echo $summary->getUrl() ?></td>
          <td><?php echo $summary->getLikes(); ?></td>
          <td><?php echo $summary->getMediaPenetration(); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  <div>
</div>