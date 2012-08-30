<h3><?php echo __('Webseiten'); ?></h3>
<?php if(count($pDp) > 0) { ?>
<ul id="tag-choice-dp-list">
<?php foreach ($pDp as $lProfile) { ?>
		<li><img height="16px" width="16" src="http://www.google.com/s2/favicons?domain=<?php echo $lProfile->getUrl(); ?>" />
		<?php echo $lProfile->getUrl(); ?></li>
<?php } ?>
</ul>
<?php } else { ?>
	<?php echo __('Derzeit konnten keine Webseiten ausgewählt werden'); ?>
<?php } ?>