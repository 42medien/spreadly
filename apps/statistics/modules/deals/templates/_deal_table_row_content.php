<?php use_helper('Date', 'DomainProfiles');
?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/chart.png')?></td>
      <td>
	      <a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      </td>
      <td>
				<?php echo $pDeal->getDomainProfile()->getUrl(); ?>
      </td>
      <td style="text-align: center;">
				<?php echo $pDeal->getStartDate(); ?>
      </td>
      <td style="text-align: center;" class="editinplaceclick" id="deal-enddate-col" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-enddate-col\"}"}'>
				<?php echo $pDeal->getEndDate(); ?>
      </td>
      <td style="text-align: center;">
				20
      </td>
      <td style="text-align: center;">
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
				<?php echo image_tag('/img/global/chart.png')?>
      </td>
      <td style="text-align: center;">
        <?php echo image_tag('/img/global/chart.png')?>
      </td>
