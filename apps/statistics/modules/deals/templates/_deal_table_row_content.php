<?php use_helper('Date', 'DomainProfiles', 'Text'); ?>

<?php if($pDeal->getState() == 'approved') { ?>
			<td align="center" class="first">
				<div>
      	<?php if($pDeal->isActive()) { ?>
      		<?php echo image_tag('/img/global/24x24/shopping_cart_accept.png', array('title' => __('Active Deal')))?>
      	<?php } else { ?>
      		<?php echo image_tag('/img/global/24x24/remove_from_shopping_cart.png', array('title' => __('Deal approved')))?>
      	<?php } ?>
      	</div>
			</td>
			<td align="left">
				<div class="padleft" title="<?php echo $pDeal->getSummary(); ?>">
					<?php echo truncate_text($pDeal->getSummary(), 20); ?>
				</div>
			</td>
			<td align="left" valign="middle">
				<div class="padleft"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div>
			</td>
			<td align="left" valign="middle">
				<div class="padleft"><?php echo format_date($pDeal->getStartDate(), 'g'); ?></div>
			</td>
  		<td align="left" valign="middle" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclick" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'>
  			<div class="padleft"><?php echo format_date($pDeal->getEndDate(), 'g'); ?></div>
  		</td>
  		<td align="center" valign="middle"><div><?php echo $pDeal->getCouponClaimedQuantity(); ?></div></td>
  		<td align="center" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><div><?php echo __($pDeal->getHumanCouponQuantity()); ?></div>
      </td>
			<td align="center">
				<div><?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?></div>
			</td>
		  <td align="center" class="last">
				<div><?php echo link_to(image_tag('/img/global/24x24/delete.png', array('title' => __('Stop Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=paused', array('class' => 'edit-state')); ?></div>
		  </td>
<?php } ?>

<?php if($pDeal->getState() == 'submitted') { ?>
      <td align="center" class="first"><div><?php echo image_tag('/img/global/24x24/process.png', array('title' => __('Deal submitted')))?></div></td>
      <td align="left"><div class="padleft"><?php echo $pDeal->getSummary(); ?></div></td>
      <td align="left" valign="middle"><div class="padleft"><?php echo $pDeal->getDomainProfile()->getUrl(); ?></div></td>
      <td align="left" valign="middle" colspan="2"><div class="padleft"><?php echo __('Not yet approved by spreadly ...'); ?></div></td>
      <td align="center" valign="middle"><div><?php echo $pDeal->getCouponClaimedQuantity(); ?></div></td>
      <td align="center" class="edit-col"><div><?php echo __($pDeal->getHumanCouponQuantity()); ?></div></td>
      <td style="text-align: center;"><div>&nbsp;</div>
      </td>
      <td align="center" class="last">
      	<div>
      		<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      	</div>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'denied') { ?>
      <td align="center" class="first"><?php echo image_tag('/img/global/24x24/warning.png', array('title' => __('Deal denied')))?></td>
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
			<td align="center" class="first"><?php echo image_tag('/img/global/24x24/clock.png', array('title' => __('Deal stopped')))?></td>
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
