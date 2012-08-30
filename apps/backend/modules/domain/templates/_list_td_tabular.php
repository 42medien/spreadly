<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($domain_profile->getId(), 'domain_profile_edit', $domain_profile) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_url">
  <?php echo link_to($domain_profile->getUrl(), $domain_profile->getDomain()) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_state">
  <?php echo $domain_profile->getState() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_verification_count">
  <?php echo $domain_profile->getVerificationCount() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_sf_guard_user_id">
  <?php echo mail_to($domain_profile->getSfGuardUser()->getEmailAddress(), 'Id: '.$domain_profile->getSfGuardUserId().' - '. $domain_profile->getSfGuardUser()->getEmailAddress()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_imprint_url">
  <a href="<?php echo $domain_profile->getImprintUrl() ?>"><?php echo $domain_profile->getImprintUrl() ?></a>
</td>
<td class="sf_admin_boolean sf_admin_list_td_detailed_analytics">
  <?php echo get_partial('domain/list_field_boolean', array('value' => $domain_profile->getDetailedAnalytics())) ?>
</td>
<td class="sf_admin_date sf_admin_list_td_created_at">
  <?php echo false !== strtotime($domain_profile->getCreatedAt()) ? format_date($domain_profile->getCreatedAt(), "d.M.y") : '&nbsp;' ?>
</td>
<td class="sf_admin_date sf_admin_list_td_updated_at">
  <?php echo false !== strtotime($domain_profile->getUpdatedAt()) ? format_date($domain_profile->getUpdatedAt(), "d.M.y") : '&nbsp;' ?>
</td>
