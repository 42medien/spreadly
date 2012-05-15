
<h3><?php echo __('User'); ?></h3>
<?php if(count($pUser) > 0) { ?>
<ul id="tag-choice-user-list">
<?php foreach ($pUser as $lUser) { ?>
		<li><?php echo $lUser->getUsername(); ?>
		<br/>
		<?php foreach($lUser->getOnlineIdentities() as $lOi) { ?>
			<img height="20px" width="20" src="/img/<?php echo $lOi->getCommunity(); ?>_icon.png" />
		<?php } ?>
	</li>
<?php } ?>
</ul>
<?php } else { ?>
	<p><?php echo __('Derzeit sind konnten User ausgewählt werden'); ?></p>
<?php } ?>