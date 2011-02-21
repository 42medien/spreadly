<div class="container_12">
	<div class="datatablewide">
  	<div class="data-tablebox">
    	<table width="100%" border="0" cellspacing="0" cellpadding="0" id="deal-table">
  		<thead>
				  <tr>
				    <th width="66" height="32" align="left" valign="middle" class="first"><div><?php echo __('Status'); ?></div></th>
				    <th width="160" align="left" valign="middle"><div><?php echo __('Deal');?></div></th>
				    <th width="170" align="left" valign="middle"><div><?php echo __('Website');?></div></th>
				    <th width="154" align="left" valign="middle"><div><?php echo __('Start');?></div> </th>
				    <th width="151" align="left" valign="middle"><div><?php echo __('End');?></div> </th>
				    <th width="75" align="left" valign="middle"><div><?php echo __('Redeemed');?></div></th>
				    <th width="60" align="left" valign="middle" ><div><?php echo __('Max');?></div></th>
				    <th width="60" align="left" valign="middle"><div><?php echo __('Edit');?></div></th>
				    <th width="64" align="left" valign="middle" class="last"> <div><?php echo __('Action');?></div></th>
				  </tr>
				</thead>
			  <tbody>
			    <?php if(count($pDeals) > 0) { ?>
				    <?php foreach ($pDeals as $i => $lDeal): ?>
				        <?php include_partial('deals/deal_table_row', array('pDeal' => $lDeal)); ?>
				    <?php endforeach; ?>
			    <?php } else { ?>
			      <tr id="no-claim">
			        <td>&nbsp;</td>
			        <td colspan="5">
			          <h3><?php echo __('No Deals');?></h3>
			        </td>
			      </tr>
			    <?php } ?>
			  </tbody>
			</table>
		</div>
	</div>
</div>