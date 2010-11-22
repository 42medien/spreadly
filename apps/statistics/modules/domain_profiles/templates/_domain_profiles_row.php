<?php use_helper('Date', 'DomainProfiles');
$i = 0;
?>

<tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>" id="domain-profile-row-<?php echo $domain_profile->getId(); ?>" <?php echo (isset($style))?$style:''; ?>>
  <?php include_partial('domain_profiles/domain_profiles_row_content', array('domain_profile' => $domain_profile));?>
</tr>
