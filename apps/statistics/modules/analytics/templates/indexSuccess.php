<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-deal-table" class="tablesorter scrolltable" style="width: 930px;">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('Deals Yesterday'); ?></div></th>
  			<th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Deals left');?></div></th>
  			<th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Days left');?></div></th>
  	    <th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Likes');?></div></th>
  	    <th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Shares');?></div></th>
  			<th height="32" align="center" valign="middle" class="last" style="white-space: nowrap;"><div class="sortlink no-sort"><?php echo __('Media Penetration'); ?></div></th>
    	</tr>
    </thead>
    <tbody>
    	<?php if(count($pDeals) > 0) { ?>
  		<?php $i = 1;?>
  		<?php foreach($pDeals as $lDeal) { ?>
  			<tr>
  				<td height="44" align="center" class="first"><div><?php echo $lDeal->getSummary(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+10; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+50; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $i+100; ?></div></td>
  				<td height="44" align="center" class="last"><div><?php echo 200-$i; ?></div></td>
  			</tr>
      <?php $i++; } ?>
      <?php } ?>
    	</tbody>
  	</table>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>


<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-website-table" class="tablesorter scrolltable" style="width: 930px;">
	  	<thead>
	    	<tr>
	  			<th height="32" align="center" valign="middle" class="first"><div class="sortlink no-sort"><?php echo __('Websites Yesterday'); ?></div></th>
	  	    <th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Likes');?></div></th>
	  	    <th align="center" valign="middle"><div class="sortlink no-sort"><?php echo __('Shares');?></div></th>
	  			<th height="32" align="center" valign="middle" class="last" style="white-space: nowrap;"><div class="sortlink no-sort"><?php echo __('Media Penetration'); ?></div></th>
	    	</tr>
	    </thead>
	    <tbody class="scrollbody">
	    	<?php if(count($pVerifiedDomains) > 0) { ?>
	  		<?php $i = 1;?>
	  		<?php foreach($pVerifiedDomains as $lDomain) { ?>
	  			<tr class="scrollrow">
	  				<td height="44" align="center" class="first"><div><?php echo link_to($lDomain->getUrl(), '@analytics?host_id='.$lDomain->getId()); ?></div></td>
	  		    <td align="center" valign="middle"><div><?php echo $pActivityCount[$lDomain->getId()]; ?></div></td>
	  		    <td align="center" valign="middle" ><div><?php echo 1603-$i; ?></div></td>
	  				<td height="44" align="center" class="last"><div><?php echo $i+674; ?></div></td>
	  			</tr>
	      <?php $i++; } ?>
	      <?php } else { ?>
	  			<tr class="scrollrow">
	  				<td height="44" align="center" class="first">&nbsp;</td>
	  				<td height="44" align="center"><?php echo __('No websites claimed');?></td>
	  				<td height="44" align="center" class="first">&nbsp;</td>
	  			</tr>
	      <?php } ?>
	    </tbody>
    </table>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
