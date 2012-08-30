<?php use_helper('Date', 'DomainProfiles');?>
		<td class="first website">
	    <?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING || (isset($pHasError) && $pHasError != false)) { ?>
				<?php echo $domain_profile->getDomain(); ?>
			<?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
	    	<a href="<?php echo url_for('analytics/domain_statistics?domainid='.$domain_profile->getId()) ?>"><?php echo $domain_profile->getDomain() ?></a>
	    <?php } ?>
		</td>
		<td class="grey verify-statecol">
			<?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING) { ?>
      	<?php if(isset($pHasError) && $pHasError != false) { ?>
        	<span class="error"><?php echo __($pHasError); ?></span>
        <?php } else {?>
       			<?php echo __('please copy & paste the verification code to your site and verify!'); ?>
        <?php }?>

      <?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
      	<i class="icon-ok icon-large"></i> <?php echo __('Verified!'); ?>&nbsp;
      	<?php if ($domain_profile->hasSubscriber() == true) { ?>
          <i class="icon-ok icon-large"></i> <?php echo link_to('Notifications enabled!', 'domain_profiles/subscribe_api?host_id='.$domain_profile->getId() , array('class' => 'colorbox')); ?>
        <?php } ?>
      <?php } ?>

    </td>
    <td class="flattr">
    <?php if ($domain_profile->getFlattrAccount()) { ?>
      <i class="icon-ok icon-large"></i> <?php echo link_to(__("Account") . ": " . $domain_profile->getFlattrAccount(), "domain_profiles/add_flattr", array("title" => __("edit flattr-account"), "query_string" => "host_id=".$domain_profile->getId())); ?>
    <?php } else { ?>
      <i class="icon-plus-sign"></i> <?php echo link_to(__("add flattr-account"), "domain_profiles/add_flattr", array("title" => __("add flattr-account"), "query_string" => "host_id=".$domain_profile->getId())); ?>
		<?php } ?>
	  </td>
		<td class="last grey">
		  <?php
		  if ($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) {
        if ($domain_profile->hasSubscriber() != true) {
          echo link_to('<i class="icon-bullhorn icon-large"></i>', 'domain_profiles/subscribe_api?host_id='.$domain_profile->getId() , array('class' => 'colorbox', 'title' => 'Setup advanced notifications now!'));
        }
        echo " ";
        if ($sf_user->hasCredential("beta_tester")) {
          echo link_to('<i class="icon-bar-chart icon-large"></i>', "domain_profiles/tracking_url?host_id=".$domain_profile->getId(), array('title' => __("Add tracking url")));
        }
		  }
      ?>
		  <a href="<?php echo url_for('domain_profiles/get_verify_code?host_id='.$domain_profile->getId()) ?>" class="get-verify-code" title="<?php echo __("Get verification-code"); ?>"><i class="icon-download-alt icon-large"></i></a>
		  <?php if($domain_profile->isPending()){ ?>
          <a class="verify-verify-code" href="<?php echo url_for('domain_profiles/verify?host_id='.$domain_profile->getId()) ?>" title="<?php echo __("Verify domain"); ?>"><i class="icon-check icon-large"></i></a>
      <?php } ?>
		  <a class="delete-verify-code" href="<?php echo url_for('domain_profiles/delete?host_id='.$domain_profile->getId()) ?>" title="<?php echo __("Delete Domain"); ?>"><i class="icon-trash icon-large"></i></a>
		</td>