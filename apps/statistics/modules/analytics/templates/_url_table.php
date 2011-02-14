<?php use_helper('Date', 'DomainProfiles') ?>
<div class="data-tablebox">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
			<th width="280" height="32" align="left" valign="middle" class="first current"><div><?php echo __('Seiten'); ?></div></th>
	    <th width="73" align="center" valign="middle"><div><?php echo __('Distribution');?></div></th>
	    <th width="48" align="center" valign="middle"><div><?php echo __('Likes');?></div> </th>
	    <th width="78" align="center" valign="middle"><div><?php echo __('Reach');?></div></th>
	    <th width="79" align="center" valign="middle" class="last"><div><?php echo __('Clickbacks');?></div></th>
  	</tr>
    <?php foreach($pData['data'] as $i => $data){ ?>
			<tr>
				<td height="44" align="left" class="first"><div class="martext"><strong>Marketing f&uuml;r Anf&auml;nger Teil 1</strong><br />
				<?php echo link_to($data['url'], '@get_analytics_content', array('query_string' => 'com=all&url='.$data['url'].'&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&type=url_activities', 'class' => 'analytix-filter-link'));  ?></div></td>
		    <td align="center"><?php echo $data['distribution'] ?>%</td>
		    <td align="center" valign="middle"><?php echo $data['pos'] ?></td>
		    <td align="center" valign="middle"><?php echo $data['contacts'] ?></td>
		    <td align="center" class="last"><?php echo $data['pis']['cb'] ?></td>
			</tr>
    <?php } ?>
	</table>
</div>