<?php use_helper('Date', 'DomainProfiles'); ?>

<?php if($pDeal->getState() == 'approved') { ?>
      <td style="width: 20px;">
      	<?php if($pDeal->isActive()) { ?>
      		<?php echo image_tag('/img/global/24x24/shopping_cart_accept.png', array('title' => __('Active Deal')))?>
      	<?php } else { ?>
      		<?php echo image_tag('/img/global/24x24/accept.png', array('title' => __('Deal approved')))?>
      	<?php } ?>
      </td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      	</td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclick" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/delete.png', array('title' => __('Stop Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=paused', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'submitted') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/process.png', array('title' => __('Deal submitted')))?></td>
      <td><?php echo $pDeal->getSummary(); ?></td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;" colspan="2"><?php echo __('Not yet approved by yiid ...'); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="edit-col"><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
      <td style="text-align: center;">
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'denied') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/warning.png', array('title' => __('Deal denied')))?></td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      </td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclickc" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'paused') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/clock.png', array('title' => __('Deal stopped')))?></td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      	</td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit end date of deal'); ?>" class="editinplaceclick edit-col" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" title="<?php echo __('Edit Coupon Quantity'); ?>" class="<?php if(!$pDeal->isUnlimited()) { ?>editinplaceclick <?php } ?> edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>><?php echo __($pDeal->getHumanCouponQuantity()); ?></td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png', array('title' => __('Edit Deal'))), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png', array('title' => __('Delete Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
        <?php echo link_to(image_tag('/img/global/24x24/next.png', array('title' => __('Proceed Deal'))), '/deals/set_state?deal_id='.$pDeal->getId().'&state=approved', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>
