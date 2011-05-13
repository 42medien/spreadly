<?php use_helper('Avatar', 'Text'); ?>
<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
<?php
$lImages = $pYiidMeta->getImages();
if ($lImages && count($lImages) > 0) {
  $lImage = $lImages[0];
} else {
  $lImage = "";
}
?>

<?php include_partial('like/like_ois', array('pIdentities' => $pIdentities))?>
<?php include_partial('like/like_content', array('pYiidMeta' => $pYiidMeta))?>

    <input type="hidden" name="like[thumb]" id="like-img-value" value="<?php echo $lImage; ?>" />
    <input type="hidden" name="like[title]" value="<?php echo htmlspecialchars($pYiidMeta->getTitle()); ?>" />
    <input type="hidden" name="like[descr]" value="<?php echo htmlspecialchars($pYiidMeta->getDescription()); ?>" />
    <input type="hidden" name="like[url]" value="<?php echo $pYiidMeta->getUrl(); ?>" />
    <input type="hidden" name="like[tags]" value="<?php echo $sf_request->getParameter('tags'); ?>" />
    <input type="hidden" name="like[clickback]" value="<?php echo $sf_request->getParameter('clickback'); ?>" />
</form>