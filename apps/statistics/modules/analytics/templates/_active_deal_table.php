<?php use_helper('YiidUrl', 'YiidNumber'); ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="active-deal-table" style="width: 940px;">
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
  		<?php
  		if ($deals) {
  		  foreach ($deals as $deal) {
  		?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo $deal->getSummary(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingCouponQuantity(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingDays() > 0 ? point_format($deal->getRemainingDays()) : __('expired'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? point_format($deal->getDealSummary()->getMediaPenetration()) : 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? point_format($deal->getDealSummary()->getClickbacks()) : 0; ?></div></td>
  				<td align="center" valign="middle" class="last"><div><?php echo $deal->getDealSummary() ? point_format($deal->getDealSummary()->getClickbackLikes()) : 0; ?></div></td>
  			</tr>
      <?php
  		  }
  		} else {
  	  ?>
        <tr>
          <td height="44" align="center" class="first" colspan="6">
          	<div><?php echo __("No Deals"); ?> <?php echo link_to(__("Click here to create one!"), 'deals/index'); ?></div></td>
        </tr>
      <?php } ?>
    	</tbody>
  	</table>
	</div>