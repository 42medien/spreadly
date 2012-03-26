<?php $author = $activity->getUser(); ?>
<entry>
  <id><?php echo $activity->getUniqueId(); ?></id>
  <title type="text"><?php echo $author->getFullName(); ?> shared "<?php echo $activity->getTitle(); ?>"</title>
  <activity:verb>http://activitystrea.ms/schema/1.0/share</activity:verb>
  <published><?php echo date("c", $activity->getC()); ?></published>
  <author>
    <name><?php echo $author->getFullName(); ?></name>
    <id><?php echo $author->getUniqueId(); ?></id>
    <?php foreach ($author->getOnlineIdentities() as $oi) { ?>
    <link rel="alternate" type="text/html" href="<?php echo $oi->getProfileUri(); ?>"  />
    <?php } ?>
    <activity:object-type>http://activitystrea.ms/schema/1.0/person</activity:object-type>
  </author>
  <activity:object>
    <id><?php echo $activity->getUrl(); ?></id>
    <title type="text"><?php echo $activity->getTitle(); ?></title>
    <activity:object-type>http://activitystrea.ms/schema/1.0/bookmark</activity:object-type>
    <published><?php echo date("c", $activity->getC()); ?></published>
    <link rel="alternate" type="text/html" href="<?php echo $activity->getUrl(); ?>" />
    <content type="html"><?php echo $activity->getDescr(); ?></content>
  </activity:object>
  <content type="html"><?php echo $activity->getComment(); ?></content>
  <link rel="alternate" type="text/html" href="<?php echo $activity->getUrl(); ?>" />
</entry>