  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="active-deal-table" style="width: 940px;">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first"><div><?php echo __('Active Deals'); ?></div></th>
  			<th align="center" valign="middle"><div><?php echo __('Deals left');?></div></th>
  			<th align="center" valign="middle"><div><?php echo __('Days left');?></div></th>
  			<th align="center" valign="middle"><div><?php echo __('Reach'); ?></div></th>
  	    <th align="center" valign="middle"><div><?php echo __('Clickbacks');?></div></th>
  	    <th align="center" valign="middle" class="last"><div><?php echo __('Clickback-Likes');?></div></th>

    	</tr>
    </thead>
    <tbody>
  		<?php if ($deal) { ?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo link_to($deal->getSummary(), 'analytics/statistics?dealid='.$deal->getId().'&type=deal'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingCouponQuantity(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getMediaPenetration() : 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbacks() : 0; ?></div></td>
  				<td align="center" valign="middle" class="last"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbackLikes() : 0; ?></div></td>
  			</tr>
      <?php } else { ?>
        <tr>
          <td height="44" align="center" class="first" colspan="6"><div><?php echo __("No Deals"); ?></div></td>
        </tr>
      <?php } ?>
    	</tbody>
  	</table>
	</div>