  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-deal-table" class="tablesorter scrolltable" style="width: 930px;">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('Active Deals'); ?></div></th>
  			<th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Deals left');?></div></th>
  			<th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Days left');?></div></th>
  			<th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Reach'); ?></div></th>
  	    <th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Clickbacks');?></div></th>
  	    <th align="center" valign="middle" class="last"><div class="sortlink no-sort"><?php echo __('Clickback-Likes');?></div></th>

    	</tr>
    </thead>
    <tbody>
  		<?php foreach($deals as $deal) { ?>
  			<tr>
  				<td height="44" align="left" class="first"><div class="padleft"><?php echo link_to($deal->getSummary(), 'analytics/statistics?dealid='.$deal->getId().'&type=deal'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingCouponQuantity(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbacks() : 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbackLikes() : 0; ?></div></td>
  				<td height="44" align="center" class="last"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getMediaPenetration() : 0; ?></div></td>
  			</tr>
      <?php } ?>
    	</tbody>
  	</table>
	</div>