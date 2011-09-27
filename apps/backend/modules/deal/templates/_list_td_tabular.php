<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($deal->getId(), 'deal_edit', $deal) ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_sf_guard_user_id">
  <?php echo mail_to($deal->getSfGuardUser()->getEmailAddress()."?subject=".$deal->getSummary(), 'Id: '.$deal->getSfGuardUserId().' - '. $deal->getSfGuardUser()->getEmailAddress()) ?>
</td>
<td class="sf_admin_text sf_admin_list_td_name">
  <?php echo $deal->getName() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_pool_hits">
  <?php echo $deal->getPoolHits() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_target_quantity">
  <?php echo $deal->getTargetQuantity() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_actual_quantity">
  <?php echo $deal->getActualQuantity() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_state">
  <?php echo $deal->getState() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_domain_profile_id">
  <?php echo $deal->getPaymentMethod() ?>
</td>