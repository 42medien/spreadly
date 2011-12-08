<?php use_helper('Date', 'DomainProfiles');?>
		<td class="first">
	    <?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING || (isset($pHasError) && $pHasError != false)) { ?>
				<?php echo $domain_profile->getDomain(); ?>
			<?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
	    	<a href="<?php echo url_for('analytics/domain_statistics?domainid='.$domain_profile->getId()) ?>"><?php echo $domain_profile->getDomain() ?></a>
	    <?php } ?>
		</td>
		<!-- td class="grey"><?php //echo image_tag(get_state_image_src($domain_profile), array('width' => '24', 'height' => '24')); ?></td -->
		<td class="grey verify-statecol">
			<?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING) { ?>
      	<?php if(isset($pHasError) && $pHasError != false) { ?>
        	<span class="error"><?php echo __($pHasError); ?></span>
        <?php } else {?>
       			<?php echo __('please copy & paste the verification code to your site and verify!'); ?>
        <?php }?>

      <?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
      	<?php echo __('Verified!'); ?>&nbsp;
        <?php if ($domain_profile->hasSubscriber() == true) { ?>
      		<?php echo link_to('Advanced notifications ok!', 'domain_profiles/subscribe_api?host_id='.$domain_profile->getId() , array('class' => 'colorbox')); ?>
      	<?php } else { ?>
      		<?php echo link_to('Setup advanced notifications now!', 'domain_profiles/subscribe_api?host_id='.$domain_profile->getId() , array('class' => 'colorbox')); ?>
      	<?php } ?>

      	<?php
          if ($sf_user->hasCredential("beta_tester")) {
            echo " | " . link_to(__("Add tracking url"), "domain_profiles/tracking_url?host_id=".$domain_profile->getId());
          }
      	?>
      <?php } ?>

    </td>
    <td><a href="<?php echo url_for('domain_profiles/get_verify_code?host_id='.$domain_profile->getId()) ?>" class="get-verify-code"><img src="/img/getcode-icon.gif" width="24" height="24" alt="Get Code" title="Get Code" /></a></td>
		<td class="grey">
	    <?php if($domain_profile->isPending()){ ?>
	    		<a class="verify-verify-code" href="<?php echo url_for('domain_profiles/verify?host_id='.$domain_profile->getId()) ?>"><img src="/img/verify-icon.gif" width="24" height="24" alt="Verify" title="Verify" /></a>
	   	<?php } ?>
		</td>
		<td class="last"><a class="delete-verify-code" href="<?php echo url_for('domain_profiles/delete?host_id='.$domain_profile->getId()) ?>"><img src="/img/delete-icon.gif" width="24" height="24" alt="Delete" /></a></td>
