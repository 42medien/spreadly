<?php use_helper('Text', 'YiidUrl', "YiidNumber"); ?>
<div class="data-tablebox">
  <table border="0" width="930px;" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first">
  				<div>
	  	    		<span class="myqtip" title="<?php echo __('Aktuell laufende Deals'); ?>">
  							<?php echo __('Active Deals'); ?>
  						</span>
		  	  </div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
	  	    	<span class="myqtip" title="<?php echo __("Anzahl der noch verfügbaren Deals"); ?>">
  						<?php echo __('Deals left');?>
  					</span>
  				</div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
	  	    	<span class="myqtip" title="<?php echo __("Restlaufzeit des Deals"); ?>">
  						<?php echo __('Days left');?>
  					</span>
  				</div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
	  	    	<span class="myqtip" title="<?php echo __('Maximale Reichweite der Empfehlung'); ?>">
  						<?php echo __('Reach'); ?>
  					</span>
	  	  	</div>
  			</th>
  	    <th align="center" valign="middle">
  	    	<div>
	  	    	<span class="myqtip" title="<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind'); ?>">
  	    			<?php echo __('Clickbacks');?>
  	    		</span>
		  	  </div>
  	    </th>
  	    <th align="center" valign="middle" class="last">
  	    	<div>
  	    		<span class="myqtip" title="<?php echo __('Anzahl der Besucher die auf eine Empfehlung gekommen sind und dann weiterempfohlen haben'); ?>">
  	    			<?php echo __('Clickback-Likes');?>
						</span>
		  	  </div>
  	    </th>
    	</tr>
    </thead>
    <tbody>
      <tr>
  				<td align="center" class="first"><div><strong class="big-font blue"><?php echo $pDeal->getLikes(); ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $pDeal->getRemainingCouponQuantity(); ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $pDeal->getRemainingDays() > 0 ? point_format($pDeal->getRemainingDays()) : __('expired'); ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $pDeal->getDealSummary() ? point_format($pDeal->getDealSummary()->getMediaPenetration()) : 0; ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $pDeal->getDealSummary() ? point_format($pDeal->getDealSummary()->getClickbacks()) : 0; ?></strong></div></td>
  				<td align="center" valign="middle" class="last"><div><strong class="big-font blue"><?php echo $pDeal->getDealSummary() ? point_format($pDeal->getDealSummary()->getClickbackLikes()) : 0; ?></strong></div></td>
      </tr>
    </tbody>
  </table>
</div>