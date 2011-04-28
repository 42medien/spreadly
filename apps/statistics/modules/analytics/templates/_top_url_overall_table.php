<?php use_helper('Date', 'DomainProfiles', 'Text', "YiidNumber") ?>
<div class="data-tablebox two-line-table">
	<table width="930px;" border="0" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
	<thead>
  	<tr>
			<th align="center" valign="middle" class="first">
				<div class="sortlink no-sort">
					<span class="myqtip" title="<?php echo __('URLs mit den meisten Empfehlungen seit Einbau des Buttons'); ?>">
						<?php echo __('Top-URLs Overall'); ?>
					</span>
	  	  </div>
			</th>
			<th align="center" valign="middle">
				<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Number of likes received for your content on your url.'); ?>">
						<?php echo __('Likes');?>
					</span>
	 	   </div>
			</th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Total number of likes published in the social networks listed.'); ?>">
	    			<?php echo __('Spreads');?>
	    		</span>
	  	  </div>
	    </th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Maximale Reichweite der Empfehlung'); ?>">
	    			<?php echo __('Reach');?>
	    		</span>
	  	  </div>
	    </th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind'); ?>">
	    			<?php echo __('Clickbacks');?>
	    		</span>
	  	  </div>
	    </th>
	    <th align="center" valign="middle" class="last">
	    	<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind und dann weiterempfohlen haben'); ?>">
	    			<?php echo __('Clickback-Likes');?>
	    		</span>
	  	  </div>
	    </th>
  	</tr>
  	</thead>
  	<tbody>
    <?php foreach($urls as $url){ ?>
			<tr>
				<td height="44" align="left" class="first">
				  <div class="padleft">
				    	<?php echo truncate_text($url->getUrl(), 60); ?>
				  </div>
  			</td>
		    <td align="center"><div><?php echo point_format($url->getLikes()); ?></div></td>
		    <td align="center" valign="middle"><div><?php echo point_format($url->getShares()); ?></div></td>
		    <td align="center" valign="middle"><div><?php echo point_format($url->getMediaPenetration()); ?></div></td>
		    <td align="center" class="last"><div><?php echo point_format($url->getClickbacks()); ?></div></td>
		    <td align="center" valign="middle"><div><?php echo point_format($url->getClickbackLikes()); ?></div></td>
			</tr>
    <?php } ?>
    </tbody>
	</table>
</div>