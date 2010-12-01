<td class="sf_admin_text sf_admin_list_td_id">
  <?php echo link_to($deal->getId(), 'deal_edit', $deal) ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_domain_profile_id">
  <?php echo $deal->getDomainProfile()->getUrl() ?>
</td>
<td class="sf_admin_foreignkey sf_admin_list_td_sf_guard_user_id">
  <?php echo mail_to($deal->getSfGuardUser()->getEmailAddress()) ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_type">
  <?php echo $deal->getType() ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_coupon_type">
  <?php echo $deal->getCouponType() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_coupon_quantity">
  <?php echo $deal->isUnlimited() ? 'unlimited' : $deal->getCouponQuantity() ?>
</td>
<td class="sf_admin_text sf_admin_list_td_coupon_claimed_quantity">
  <?php echo $deal->getCouponClaimedQuantity() ?>
</td>
<td class="sf_admin_date sf_admin_list_td_start_date">
  <?php echo format_date($deal->getStartDate(), "d.M.y") ?>
</td>
<td class="sf_admin_date sf_admin_list_td_end_date">
  <?php echo format_date($deal->getEndDate(), "d.M.y") ?>
</td>
<td class="sf_admin_enum sf_admin_list_td_state">
  <?php echo $deal->getState() ?>
</td>
