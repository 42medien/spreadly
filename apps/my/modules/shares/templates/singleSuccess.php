<div class="row h-entry hentry">
  <div class="span2 p-author h-card">
    <p><?php echo image_tag($activity->getUser()->getAvatar(), array("class" => "u-photo")); ?></p>
    <p class="p-name"><?php echo $activity->getUser()->getFullname(); ?></p>
  </div>
  <div class="span10">
    <?php include_partial("share", array("activity" => $activity)); ?>
  </div>
</div>