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