<?php use_helper('Date', 'DomainProfiles'); ?>

<tr id="domain-profile-row-<?php echo $domain_profile->getId(); ?>" class="<?php echo ($domain_profile->getState() == DomainProfileTable::STATE_PENDING)? "unverifiedrow":""; ?> ">
  <?php include_partial('domain_profiles/domain_profiles_row_content', array('domain_profile' => $domain_profile));?>
</tr>