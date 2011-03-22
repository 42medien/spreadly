<?php use_helper('Date', 'DomainProfiles') ?>
<div class="data-tablebox">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
			<th width="280" height="32" align="left" valign="middle" class="first current"><div><?php echo __('Websites'); ?></div></th>
	    <th width="73" align="center" valign="middle"><div><?php echo __('Distribution');?></div></th>
	    <th width="48" align="center" valign="middle"><div><?php echo __('Likes');?></div> </th>
	    <th width="78" align="center" valign="middle"><div><?php echo __('Reach');?></div></th>
	    <th width="79" align="center" valign="middle" class="last"><div><?php echo __('Clickbacks');?></div></th>
  	</tr>
    <?php foreach($pData['data'] as $i => $data){ ?>
			<tr>
				<td height="44" align="left" class="first">
				  <div class="martext">
				  	<?php if($data['title'] && $data['title']!='') { ?>
				    	<strong><?php echo $data['title'] ?></strong>
				    <?php } else {?>
				    	<strong><?php echo __('No title'); ?></strong>
				    <?php } ?>
				    	<br />
    				<?php if($pHostId && $pFrom && $pTo): ?>
      				<?php echo link_to($data['url'], '@get_analytics_content', array('query_string' => 'com=all&url='.$data['url'].'&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&type=url_activities', 'class' => 'analytix-filter-link table-filter-link'));  ?>
      			<?php else: ?>
      			  <?php echo $data['url'] ?>
      			<?php endif; ?>
  			  </div>
  			</td>
		    <td align="center"><?php echo $data['distribution'] ?>%</td>
		    <td align="center" valign="middle"><?php echo $data['pos'] ?></td>
		    <td align="center" valign="middle"><?php echo $data['contacts'] ?></td>
		    <td align="center" class="last"><?php echo $data['pis']['cb'] ?></td>
			</tr>
    <?php } ?>
	</table>
</div>
