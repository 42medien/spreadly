<?php use_helper('Date', 'DomainProfiles'); ?>

<?php if($pDeal->getState() == 'approved') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/accept.png')?></td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      	</td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" class="editinplaceclick" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="editinplaceclick edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>>
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png'), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/delete.png'), '/deals/set_state?deal_id='.$pDeal->getId().'&state=paused', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'submitted') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/process.png')?></td>
      <td><?php echo $pDeal->getSummary(); ?></td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;" colspan="2"><?php echo __('Not yet approved by yiid ...'); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="edit-col">
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png'), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'denied') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/warning.png')?></td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      	</td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" class="editinplaceclick edit-col" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="editinplaceclick edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>>
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png'), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png'), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'trashed') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/remove.png')?></td>
      <td><?php echo $pDeal->getSummary(); ?></td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" class="edit-col"><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="edit-col">
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
      </td>
      <td style="text-align: center;">
      </td>
<?php } ?>

<?php if($pDeal->getState() == 'paused') { ?>
      <td style="width: 20px;"><?php echo image_tag('/img/global/24x24/clock.png')?></td>
      <td>
      	<a href="<?php echo url_for('/') ?>"><?php echo $pDeal->getSummary(); ?></a>
      	</td>
      <td><?php echo $pDeal->getDomainProfile()->getUrl(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getStartDate(); ?></td>
      <td style="text-align: center;" class="editinplaceclick edit-col" id="deal-date-<?php echo $pDeal->getId(); ?>" data-obj='{"action":"/deals/edit_enddate", "type":"text", "callback":"DealTable.editDate",  "params": "{\"id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-date-<?php echo $pDeal->getId(); ?>\"}"}'><?php echo $pDeal->getEndDate(); ?></td>
      <td style="text-align: center;"><?php echo $pDeal->getCouponClaimedQuantity(); ?></td>
      <td style="text-align: center;" class="editinplaceclick edit-col" id="deal-quantity-<?php echo $pDeal->getId(); ?>"
      	<?php if($pDeal->getCouponType() == "single"){ ?>data-obj='{"action":"/deals/save_quantity", "type":"text",  "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } else { ?> data-obj='{"action":"/deals/paste_codes?deal_id=<?php echo $pDeal->getId(); ?>", "type":"layer", "params": "{\"deal_id\":\"<?php echo $pDeal->getId(); ?>\", \"cssid\":\"deal-quantity-<?php echo $pDeal->getId(); ?>\"}"}'
      	<?php } ?>>
				<?php echo $pDeal->getCouponQuantity(); ?>
      </td>
      <td style="text-align: center;">
				<?php echo link_to(image_tag('/img/global/24x24/tools.png'), '/deals/get_create_form?deal_id='.$pDeal->getId(), array('class' => 'link-deal-content')); ?>
      </td>
      <td style="text-align: center;">
      	<?php echo link_to(image_tag('/img/global/24x24/trash.png'), '/deals/set_state?deal_id='.$pDeal->getId().'&state=trashed', array('class' => 'edit-state')); ?>
        <?php echo link_to(image_tag('/img/global/24x24/next.png'), '/deals/set_state?deal_id='.$pDeal->getId().'&state=approved', array('class' => 'edit-state')); ?>
      </td>
<?php } ?>
