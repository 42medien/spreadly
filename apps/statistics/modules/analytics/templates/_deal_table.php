  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-deal-table" class="tablesorter scrolltable" style="width: 930px;">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first"><div class="sortlink"><?php echo __('Deals Yesterday'); ?></div></th>
  			<th align="center" valign="middle"><div class="sortlink"><?php echo __('Deals left');?></div></th>
  			<th align="center" valign="middle"><div class="sortlink"><?php echo __('Days left');?></div></th>
  	    <th align="center" valign="middle"><div class="sortlink"><?php echo __('Likes');?></div></th>
  	    <th align="center" valign="middle"><div class="sortlink"><?php echo __('Shares');?></div></th>
  			<th height="32" align="center" valign="middle" class="last" style="white-space: nowrap;"><div class="sortlink"><?php echo __('Media Penetration'); ?></div></th>
    	</tr>
    </thead>
    <tbody>
  		<?php $i = 1;?>
  		<?php foreach($pDeals as $lDeal) { ?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo link_to($lDeal->getSummary(), 'analytics/statistics?dealid='.$lDeal->getId().'&type=deal'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+10; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+50; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+100; ?></div></td>
  				<td align="center" class="last"><div><?php echo 200-$i; ?></div></td>
  			</tr>
      <?php $i++; } ?>
    	</tbody>
  	</table>
	</div>