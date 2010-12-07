<?php use_helper('Date', 'DomainProfiles');
$i = 0;
?>

<tr class="odd <?php echo $pDeal->getCssClasses(); ?> " id="domain-profile-row-<?php echo $pDeal->getId(); ?>" <?php echo (isset($style))?$style:''; ?>>
  <?php include_partial('deals/deal_table_row_content', array('pDeal' => $pDeal));?>
</tr>