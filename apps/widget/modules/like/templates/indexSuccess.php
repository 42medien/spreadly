<?php use_helper('Avatar', 'Text'); ?>
<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
		<?php //include_partial('like/like_ois', array('pIdentities' => $pIdentities))?>
		<?php include_partial('like/like_content', array('pYiidMeta' => $pYiidMeta, 'pIdentities' => $pIdentities))?>
</form>