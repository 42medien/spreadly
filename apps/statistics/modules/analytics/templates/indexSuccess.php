<?php slot('content') ?>
  <div class="data-tablebox">
  	<table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
  			<th width="70" height="32" align="center" valign="middle" class="first"><div><?php echo __('Rank'); ?></div></th>
  	    <th align="center" valign="middle"><div><?php echo __('Website');?></div></th>
  			<th width="120" height="32" align="center" valign="middle" class="last"><div><?php echo __('Todays Activities'); ?></div></th>
    	</tr>
    	<?php if(count($pVerifiedDomains) > 0) { ?>
  		<?php $i = 1;?>
  		<?php foreach($pVerifiedDomains as $lDomain) { ?>
  			<tr>
  				<td height="44" align="center" class="first"><?php echo $i; ?></td>
  		    <td align="center" valign="middle"><?php echo link_to($lDomain->getUrl(), '@analytics?host_id='.$lDomain->getId()); ?></td>
  				<td height="44" align="center" class="last"><?php echo $pActivityCount[$lDomain->getId()]; ?></td>
  			</tr>
      <?php $i++; } ?>
      <?php } else { ?>
  			<tr>
  				<td height="44" align="center" class="first">&nbsp;</td>
  				<td height="44" align="center"><?php echo __('No websites claimed');?></td>
  				<td height="44" align="center" class="first">&nbsp;</td>
  			</tr>
      <?php } ?>
  	</table>
  </div>

  <div style="margin-top:30px">
  <?php include_partial('url_table', array("pHostId" => null, "pFrom" => null, "pTo" => null, "pData" => $pTopActivitiesData)) ?>
  </div>
<?php end_slot(); ?>

<?php include_partial('global/graybox'); ?>
