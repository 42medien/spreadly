<?php use_helper('Date', 'DomainProfiles');
?>
    <td height="43" align="right"><img src="/img/site-icon.gif" width="24" height="24" alt="Site" title="Site" /></td>
    <td class="webname">
    <?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING || (isset($pHasError) && $pHasError != false)) { ?>
			<?php echo $domain_profile->getDomain(); ?>
		<?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
    	<a href="<?php echo url_for('analytics/domain_statistics?domainid='.$domain_profile->getId()) ?>"><?php echo $domain_profile->getDomain() ?></a>
    <?php } ?>
    </td>
    <td align="center" valign="middle"><?php echo image_tag(get_state_image_src($domain_profile), array('width' => '24', 'height' => '24')); ?></td>
    <td>
    	<?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING) { ?>
      	<?php if(isset($pHasError) && $pHasError != false) { ?>
        	<span class="error"><?php echo __($pHasError); ?></span>
        <?php } else {?>
       		<?php echo __('please copy & paste the verification code to your site and verify!'); ?>
        <?php }?>

      <?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
      	<?php echo __('Verified!'); ?>
      <?php } ?>
    </td>
    <td align="center" valign="middle">
    	<a href="<?php echo url_for('domain_profiles/get_verify_code?host_id='.$domain_profile->getId()) ?>" class="get-verify-code"><img src="/img/getcode-icon.gif" width="24" height="24" alt="Get Code" title="Get Code" /></a>
    </td>
   	<td align="center" valign="middle">
    <?php if($domain_profile->isPending()){ ?>
    		<a class="verify-verify-code" href="<?php echo url_for('domain_profiles/verify?host_id='.$domain_profile->getId()) ?>"><img src="/img/verify-icon.gif" width="24" height="24" alt="Verify" title="Verify" /></a>
   	<?php } ?>
   	</td>
    <td align="center" valign="middle">
    	<a class="delete-verify-code" href="<?php echo url_for('domain_profiles/delete?host_id='.$domain_profile->getId()) ?>"><img src="/img/delete-icon.gif" width="24" height="24" alt="Delete" /></a>
    </td>
    <td></td>