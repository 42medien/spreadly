<?php use_helper('Date', 'DomainProfiles'); ?>
<tr id="deal-table-row-<?php echo $pDeal->getId(); ?>" class="<?php echo $pDeal->getCssClasses(); ?>" <?php echo (isset($style))?$style:''; ?>>
  <?php include_partial('deals/deal_table_row_content', array('pDeal' => $pDeal));?>
</tr>