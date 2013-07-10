<?php $link_class = "like"; ?>

<h2><?php echo link_to($activity->getTitle(), "@share?id=".$activity->getId()); ?></h2>
<p><strong><?php echo $activity->getDescr(); ?></strong></p>
<?php if ($activity->getComment()) { ?>
  <?php $link_class = "in-reply-to"; ?>
  <p><i class="icon-comment"></i> <span class="p-summary p-name"><?php echo $activity->getComment(); ?></span></p>
<?php } else { ?>
  <p style="display: none"><span class="p-summary p-name"><?php echo $activity->getUser()->getFullname(); ?> liked "<?php echo $activity->getTitle(); ?>"</span></p>
<?php } ?>
<p><i class="icon-time"></i> <time datetime="<?php echo date("c", $activity->getC()); ?>" class="dt-published dt-updated"><?php echo date("d.m.Y / H:i", $activity->getC()); ?></time></p>
<p><i class="icon-external-link"></i> <?php echo link_to($activity->getUrl(), $activity->getUrl(), array("target" => "_blank", "class" => "u-".$link_class, "rel" => $link_class)); ?></p>
<?php if ($activity->getTags()) { ?>
  <i class="icon-tags"></i> <?php echo simple_tag_list($activity->getTags(), array("separator" => ","), "shares/index?t="); ?>
<?php } ?>