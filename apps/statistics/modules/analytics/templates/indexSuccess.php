<?php slot('content') ?>
  <h3 class="verifytitle">Claim your sites</h3>

  <div class="data-tablebox">
  	<table width="77%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
  			<th width="1" height="32" align="left" valign="middle" class="first"><div><?php echo __('Rank'); ?></div></th>
  	    <th width="575" align="center" valign="middle" class="last"><div><?php echo __('Website');?></div></th>
    	</tr>
    	<?php if(count($pVerifiedDomains) > 0) { ?>
  		<?php $i = 1;?>
  		<?php foreach($pVerifiedDomains as $lDomain) { ?>
  			<tr>
  				<td height="44" align="center" class="first"><?php echo $i; ?></td>
  		    <td align="center" valign="middle" class="last"><?php echo link_to($lDomain->getUrl(), '@analytics?host_id='.$lDomain->getId()); ?></td>
  			</tr>
      <?php $i++; } ?>
      <?php } else { ?>
  			<tr>
  				<td height="44" align="center" class="first">&nbsp;</td>
  				<td height="44" align="center" class="last"><?php echo __('No websites claimed');?></td>
  			</tr>
      <?php } ?>
  	</table>
  </div>
<?php end_slot(); ?>

<?php include_partial('global/graybox'); ?>
