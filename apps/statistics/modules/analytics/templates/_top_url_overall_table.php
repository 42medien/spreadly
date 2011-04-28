<?php use_helper('Date', 'DomainProfiles', 'Text') ?>
<div class="data-tablebox two-line-table">
	<table width="930px;" border="0" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
	<thead>
  	<tr>
			<th align="center" valign="middle" class="first">
				<div class="sortlink no-sort">
					<?php echo __('Top-URLs Overall'); ?>
		  	  <a href="#" class="helptip">
	        	<img src="/img/qus_icon.png" alt="<?php echo __("Top-URLs Overall"); ?>" class="tooltip-icon" />
	        </a>
	  	  </div>
	      <div class="tooltip">
	      	<h3><?php echo __('Top-URLs Overall'); ?></h3>
	      	<?php echo __('URLs mit den meisten Empfehlungen seit Einbau des Buttons'); ?>
	      </div>
			</th>
			<th align="center" valign="middle">
				<div class="sortlink">
					<?php echo __('Likes');?>
	  	    <a href="#" class="helptip">
          	<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          </a>
	  	   </div>
	       <div class="tooltip"><h3><?php echo __('Likes'); ?></h3><?php echo __('Number of likes received for your content on your url.'); ?></div>
			</th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
	    		<?php echo __('Spreads');?>
		  	  <a href="#" class="helptip">
	        	<img src="/img/qus_icon.png" alt="<?php echo __("Spreads"); ?>" class="tooltip-icon" />
	        </a>
	  	  </div>
	      <div class="tooltip"><h3><?php echo __('Spreads'); ?></h3><?php echo __('Total number of likes published in the social networks listed.'); ?></div>
	    </th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
	    		<?php echo __('Reach');?>
		  	  <a href="#" class="helptip">
	        	<img src="/img/qus_icon.png" alt="<?php echo __("Reach"); ?>" class="tooltip-icon" />
	        </a>
	  	  </div>
	      <div class="tooltip"><h3><?php echo __('Reach'); ?></h3><?php echo __('Maximale Reichweite der Empfehlung'); ?></div>
	    </th>
	    <th align="center" valign="middle">
	    	<div class="sortlink">
	    		<?php echo __('Clickbacks');?>
		  	  <a href="#" class="helptip">
	        	<img src="/img/qus_icon.png" alt="<?php echo __("Clickbacks"); ?>" class="tooltip-icon" />
	        </a>
	  	  </div>
	      <div class="tooltip">
	      	<h3><?php echo __('Clickbacks'); ?></h3>
	      	<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind'); ?>
	      </div>
	    </th>
	    <th align="center" valign="middle" class="last">
	    	<div class="sortlink">
	    		<?php echo __('Clickback-Likes');?>
		  	  <a href="#" class="helptip">
	        	<img src="/img/qus_icon.png" alt="<?php echo __("Clickback-Likes"); ?>" class="tooltip-icon" />
	        </a>
	  	  </div>
	      <div class="tooltip">
	      	<h3><?php echo __('Clickback-Likes'); ?></h3>
	      	<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind und dann weiterempfohlen haben'); ?>
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
		    <td align="center"><div><?php echo $url->getLikes() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getShares() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getMediaPenetration() ?></div></td>
		    <td align="center" class="last"><div><?php echo $url->getClickbacks() ?></div></td>
		    <td align="center" valign="middle"><div><?php echo $url->getClickbackLikes() ?></div></td>
			</tr>
    <?php } ?>
    </tbody>
	</table>
</div>