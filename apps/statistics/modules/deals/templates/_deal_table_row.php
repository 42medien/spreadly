<?php use_helper('Date', 'DomainProfiles');
$i = 0;
?>

<tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>" id="domain-profile-row-<?php echo $pDeal->getId(); ?>" <?php echo (isset($style))?$style:''; ?>>
  <?php include_partial('deals/deal_table_row_content', array('pDeal' => $pDeal));?>
</tr>