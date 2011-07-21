<?php use_helper('Text', 'Avatar'); ?>
<?php slot('headline') ?>
	<h2><?php echo __('Your settings');?></h2>
<?php end_slot(); ?>

<div class="shadow-light bordered-light clearfix" id="profile-info">
	<img src="<?php echo avatar_path($sf_user->getUser()->getAvatar(), '48'); ?>" class="shadow alignleft" id="profile-img" width="48" height="48" alt="<?php echo $pUser->getUsername(); ?>" title="<?php echo $pUser->getUsername(); ?>" />
	<div class="alignleft">
  	<p><strong><?php echo $pUser->getUsername(); ?></strong></p>
    <!-- p><?php //echo truncate_text(strip_tags('Zunächst hatte das Gefängnis Angst, es könne zu Übergriffen anderer Gefangener kommen. Alleine diese Angst ist schon ein Armutszeugnis für unsere Gesellschaft – das Grundrecht auf körperliche Unversehrtheit'), 40); ?></p -->
    <p>
			<?php foreach ($pIdentities as $lIdentity) { ?>
      	<a href="<?php echo url_for($lIdentity->getProfileUri()) ?>" target="_blank" title="<?php echo $lIdentity->getName().": ".$lIdentity->getUrl(); ?>"><img src="/img/<?php echo $lIdentity->getCommunity()->getCommunity(); ?>-favicon.gif" width="17" height="17" alt="<?php echo $lIdentity->getName().": ".$lIdentity->getUrl(); ?>" /></a>
      <?php } ?>
    </p>
	</div>
    <div class="alignright friends-box">
    		<div class="totalfriend">
					<span><?php echo $pUser->getFriendCount(); ?></span>
					<br /><?php echo __('friends'); ?>
				</div>
				<?php echo $pUser->getInfluencerRank(); ?>
    </div>
</div>

<div id="update-networks-box">
	<h3><?php echo __('Social Networks'); ?></h3>
	<?php echo __('Likes will be posted immediately to the networks you have selected below.'); ?>

	<ul class="clearfix" id="update-settings-list">
	<?php foreach ($pIdentities as $lIdentity) { ?>
		<li class="clearfix">
			<input type="checkbox" value="<?php echo $lIdentity->getId(); ?>" class="update-settings-cb alignleft" id="" name="" <?php echo $lIdentity->getSocialPublishingEnabled()?"checked='checked'":''; ?>/>
			<div class="alignleft">
				<a href="<?php echo url_for($lIdentity->getProfileUri()) ?>" class="show-profile-link" target="_blank" title="<?php echo $lIdentity->getName(); ?>">
					<img src="/img/<?php echo $lIdentity->getCommunity()->getCommunity(); ?>-favicon.gif" class="alignleft" width="16" height="16" alt="<?php echo $lIdentity->getName(); ?>" />
					<span class="network-name"><?php echo truncate_text($lIdentity->getName(), 25); ?></span>
				</a>
			</div>
		</li>
	<?php } ?>
	</ul>
</div>
<div id="add-accounts-box" class="alignright clearfix">
	<p>
		<?php echo __('Add more accounts:'); ?><?php echo link_to(image_tag("/img/facebook-add.gif"), "@signinto?service=facebook&r=s"); ?><?php echo link_to(image_tag("/img/twiiter-add.gif"), "@signinto?service=twitter&r=s"); ?><?php echo link_to(image_tag("/img/in-add.gif"), "@signinto?service=linkedin&r=s"); ?><?php echo link_to(image_tag("/img/buzz-add.gif"), "@signinto?service=google&r=s"); ?>
	</p>
</div>
