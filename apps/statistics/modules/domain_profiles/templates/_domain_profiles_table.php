<?php use_helper('Date', 'DomainProfiles') ?>
<div class="data-table" id="domain_profiles_table">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <thead>
	  <tr class="table-title">
	    <th><img src="/img/table-thl.jpg" width="5" height="34" alt="" class="alignleft" /></th>
	    <th align="center" valign="middle"><?php echo __('Website');?></th>
	    <th align="center" valign="middle">&nbsp;</th>
	    <th align="center" valign="middle"><?php echo __('Status');?></th>
	    <th align="center" valign="middle"><?php echo __('Get Code');?></th>
	    <th align="center" valign="middle"><?php echo __('Verify');?></th>
	    <th align="center" valign="middle"><?php echo __('Delete');?></th>
	    <th align="center" valign="middle"><img src="/img/table-thr.jpg" width="5" height="34" alt="" class="alignright" /></th>
	  </tr>
	  </thead>
	  <tbody>
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
	  </tbody>
	</table>
</div>
