<?php use_helper('Date', 'DomainProfiles') ?>


<table id="domain_profiles_table" cellspacing="0" class="full sheet">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo __('Website');?></th>
      <th><?php echo __('Status');?></th>
      <th><?php echo __('Get Code');?></th>
      <th><?php echo __('Verify');?></th>
      <th><?php echo __('Delete');?></th>
    </tr>
  </thead>
  <tbody>
    <?php if(count($domain_profiles) > 0) { ?>
	    <?php foreach ($domain_profiles as $i => $domain_profile): ?>
	        <?php include_partial('domain_profiles/domain_profiles_row', array('domain_profile' => $domain_profile)); ?>
	    <?php endforeach; ?>
    <?php } else { ?>
      <tr id="no-claim">
        <td>&nbsp;</td>
        <td colspan="5">
          <h3><?php echo __('No websites claimed');?></h3>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>

