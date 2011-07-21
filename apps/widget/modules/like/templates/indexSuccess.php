<?php use_helper('Avatar', 'Text'); ?>
<?php slot('headline') ?>
	<h2><?php echo __('Like it!'); ?></h2>
<?php end_slot(); ?>

<form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
		<?php //include_partial('like/like_ois', array('pIdentities' => $pIdentities))?>
		<?php include_partial('like/like_content', array('pYiidMeta' => $pYiidMeta, 'pIdentities' => $pIdentities))?>
</form>