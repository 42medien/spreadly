<?php use_helper('Date', 'DomainProfiles'); ?>

<?php if($pDeal->getState() == 'approved') { ?>
			<td height="43" align="center" class="first">
      	<?php if($pDeal->isActive()) { ?>
      		<?php echo image_tag('/img/global/24x24/shopping_cart_accept.png', array('title' => __('Active Deal')))?>
      	<?php } else { ?>
      		<?php echo image_tag('/img/global/24x24/remove_from_shopping_cart.png', array('title' => __('Deal approved')))?>
      	<?php } ?>
			</td>
			<td align="left">
				<div class="marketbox">
					<?php echo link_to($pDeal->getSummary(), '@get_analytics_content', array('query_string' => 'isdeal=1&com=all&host_id='.$pDeal->getDomainProfileId().'&date-from='.$pDeal->getStartDate().'&date-to='.$pDeal->getEndDate().'&url=&dealid='.$pDeal->getId(), 'class' => 'deal-stats-link', 'title' => __('Show analytics'))); ?>
				</div>
			</td>
			<td align="left" valign="middle">
				<div class="marketbox"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div>
			</td>
			<td align="left" valign="middle">
				<div  class="marketbox"><?php echo $pDeal->getStartDate(); ?></div>
			</td>
  		<td align="left" valign="middle" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclick" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'>
  			<div  class="marketbox"><?php echo $pDeal->getEndDate(); ?></div>
  		</td>
  		<td align="center" valign="middle"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
  		<td align="center" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?>
      </td>
			<td align="center">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'), 'width' => '29', 'height' => '28')), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
			</td>
		  <td align="center" class="last">
				<?php echo link_to(image_tag('/img/global/24x24/delete.png', array('title' => __('Stop Deal'), 'width' => '29', 'height' => '28')), '/deals/set_state?deal_id='.$pDeal->getId().'&state=paused', array('class' => 'edit-state')); ?>
		  </td>
<?php } ?>

<?php if($pDeal->getState() == 'submitted') { ?>
      <td height="43" align="center" class="first"><?php echo image_tag('/img/global/24x24/process.png', array('title' => __('Deal submitted')))?></td>
      <td align="left"><div class="marketbox"><?php echo $pDeal->getSummary(); ?></div></td>
      <td align="left" valign="middle"><div class="marketbox"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div></td>
      <td align="left" valign="middle" colspan="2"><div class="marketbox"><?php echo __('Not yet approved by yiid ...'); ?></div></td>
      <td align="center" valign="middle"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td align="center" class="edit-col"><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
      <td style="text-align: center;">
      </td>
      <td align="center" class="last">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'denied') { ?>
      <td height="43" align="center" class="first"><?php echo image_tag('/img/global/24x24/warning.png', array('title' => __('Deal denied')))?></td>
      <td align="left"><div  class="marketbox"><?php echo $pDeal->getSummary(); ?></div></td>
      <td align="left" valign="middle"><div class="marketbox"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div></td>
      <td align="left" valign="middle"><div class="marketbox"><?php echo $pDeal->getStartDate(); ?></div></td>
			<td align="left" valign="middle" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclickc" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'>
				<div  class="marketbox">
					<?php echo $pDeal->getEndDate(); ?>
				</div>
			</td>
			<td align="center" valign="middle"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
			<td align="center" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?>
			</td>
			<td align="center">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
			</td>
       <td align="center" class="last">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'paused') { ?>
			<td height="43" align="center" class="first"><?php echo image_tag('/img/global/24x24/clock.png', array('title' => __('Deal stopped')))?></td>
		  <td align="left"><div class="marketbox"><?php echo link_to($pDeal->getSummary(), '@get_analytics_content', array('class' => 'deal-stats-link')); ?></div></td>
		  <td align="left" valign="middle"><div class="marketbox"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div></td>
		  <td align="left" valign="middle"><div class="marketbox"><?php echo $pDeal->getStartDate(); ?></div></td>
		  <td align="left" valign="middle" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclick edit-col" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><div  class="marketbox"><?php echo $pDeal->getEndDate(); ?></div></td>
		  <td align="center" valign="middle"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
		  <td align="center" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
		  <td align="center"><?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?></td>
		  <td align="center" class="last">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
        <?php echo link_to(image_tag('/img/global/24x24/next.png', array('title' => __('Proceed Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=approved', array('class' => 'edit-state')); ?>
		  </td>
<?php } ?>
