<?php use_helper('Date', 'DomainProfiles'); ?>

<tr id="deal-table-row-<?php echo $pDeal->getId(); ?>">
  <?php include_partial('deals/deal_table_row_content', array('pDeal' => $pDeal));?>
</tr>