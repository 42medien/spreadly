<table id="deal_table" cellspacing="0" class="full sheet">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo __('Deal');?></th>
      <th><?php echo __('Website');?></th>
      <th><?php echo __('Start');?></th>
      <th><?php echo __('End');?></th>
      <th><?php echo __('Claimed');?></th>
      <th><?php echo __('Max');?></th>
      <th><?php echo __('Edit');?></th>
      <th><?php echo __('Active');?></th>
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
          <h3><?php echo __('No websites claimed');?></h3>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="9">&nbsp;</td>
    </tr>
  </tfoot>
</table>