<?php use_helper('Date', 'DomainProfiles', 'Text') ?>
<div class="data-tablebox">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tr>
			<th width="280" height="32" align="left" valign="middle" class="first current"><div><?php echo __('Top-URLs Overall'); ?></div></th>
			<th width="48" align="center" valign="middle"><div><?php echo __('Likes');?></div></th>
	    <th width="73" align="center" valign="middle"><div><?php echo __('Spreads');?></div></th>
	    <th width="78" align="center" valign="middle"><div><?php echo __('Reach');?></div></th>
	    <th width="79" align="center" valign="middle"><div><?php echo __('Clickbacks');?></div></th>
	    <th width="79" align="center" valign="middle" class="last"><div><?php echo __('Clickback Likes');?></div></th>
  	</tr>
    <?php foreach($urls as $url){ ?>
			<tr>
				<td height="44" align="left" class="first" style="line-height: 21px;">
				  <div class="martext">
				  	<?php if($url->getTitle() && $url->getTitle()!='') { ?>
				    	<strong><?php echo truncate_text($url->getTitle(), 60); ?></strong>
				    <?php } else {?>
				    	<strong><?php echo __('No title'); ?></strong>
				    <?php } ?>
				    	<br />
				    	<?php echo link_to($url->getUrl(), 'analytics/url_statistics', array('query_string' => 'url='.urlencode($url->getUrl()).'&amp;host='.urlencode($url->getHost()), 'class' => 'analytix-filter-link table-filter-link'));  ?>
      				<?php //echo link_to($data['url'], 'analytics/url_statistics', array('query_string' => 'com=all&url='.$data['url'].'&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&type=url_activities', 'class' => 'analytix-filter-link table-filter-link'));  ?>
  			  </div>
  			</td>
		    <td align="center"><div><?php echo $url->getLikes() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getShares() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getMediaPenetration() ?></div></td>
		    <td align="center" class="last"><div><?php echo $url->getClickbacks() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getClickbackLikes() ?></div></td>
			</tr>
    <?php } ?>
	</table>
</div>