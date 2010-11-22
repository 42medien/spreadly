<?php use_helper('Date', 'DomainProfiles');
?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/chart.png')?></td>
      <td>
        <?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING || (isset($pHasError) && $pHasError != false)) { ?>
          <span class="error"><?php echo $domain_profile->getDomain(); ?></span>
        <?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
          <a href="<?php echo url_for('visit_history/analytics?host_id='.$domain_profile->getId()) ?>"><?php echo $domain_profile->getDomain() ?></a>
        <?php } ?>
      </td>
      <td>
        <?php echo image_tag(get_state_image_src($domain_profile), array('class' => 'left')); ?>
        <?php if($domain_profile->getState() == DomainProfileTable::STATE_PENDING) { ?>
          <span class="error verify-table-info">
            <?php if(isset($pHasError) && $pHasError != false) { ?>
              <?php echo __($pHasError); ?>
            <?php } else {?>
              <?php echo __('please copy & paste the verification code to your site and verify!'); ?>
            <?php }?>
          </span>
        <?php } elseif($domain_profile->getState() == DomainProfileTable::STATE_VERIFIED) { ?>
          <span class="verify-table-info">
            <?php echo __('Verified!'); ?>
          </span>
        <?php } ?>
      </td>
      <td class="numeric" style="text-align: center;">
        <a class="get-verify-code" href="<?php echo url_for('domain_profiles/get_verify_code?host_id='.$domain_profile->getId()) ?>"><?php echo image_tag('/img/global/download.png');?></a>
        <?php //echo link_to('Delete', 'domain_profiles/delete?id='.$domain_profile->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'class' => 'button negative inline')) ?>
      </td>
      <td style="text-align: center;">
        <?php if($domain_profile->isPending()){ ?>
          <a class="verify-verify-code" href="<?php echo url_for('domain_profiles/verify?host_id='.$domain_profile->getId()) ?>"><?php echo image_tag('/img/global/refresh.png');?></a>
        <?php }?>
      </td>
      <td style="text-align: center;">
        <a class="delete-verify-code" href="<?php echo url_for('domain_profiles/delete?host_id='.$domain_profile->getId()) ?>"><?php echo image_tag('/img/global/trash.png');?></a>
      </td>
