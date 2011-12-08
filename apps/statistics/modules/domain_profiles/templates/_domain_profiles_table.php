<?php use_helper('Date', 'DomainProfiles') ?>


<div class="claimtable-head">
	<span class="leftco">&nbsp;</span><span class="rightco">&nbsp;</span>
	<table title="Recurring Billing Features">
		<tr>
			<td class="first"><?php echo __('Website');?></td>
			<td class="status"><?php echo __('Status');?></td>
			<td class="generate"><?php echo __('Get Code');?></td>
			<td><?php echo __('Verify');?></td>
			<td><?php echo __('Delete');?></td>
		</tr>
	</table>
</div>
<table class="custofeature-table" id="domain_profiles_table" title="table">
	  <?php if(count($domain_profiles) > 0) { ?>
	    <?php foreach ($domain_profiles as $i => $domain_profile){ ?>
				<?php include_partial('domain_profiles/domain_profiles_row', array('domain_profile' => $domain_profile)); ?>
			<?php } ?>
	  <?php } else { ?>
      <tr id="no-claim">
        <td>&nbsp;</td>
        <td colspan="7">
          <h3><?php echo __("No websites claimed");?></h3>
        </td>
      </tr>
	  <?php } ?>

</table>
