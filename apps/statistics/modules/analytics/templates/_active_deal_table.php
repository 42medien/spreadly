  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="active-deal-table" style="width: 940px;">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first">
  				<div>
  					<?php echo __('Active Deals'); ?>
			  	  <a href="#" class="helptip">
		        	<img src="/img/qus_icon.png" alt="<?php echo __("Active Deals"); ?>" class="tooltip-icon" />
		        </a>
		  	  </div>
		      <div class="tooltip">
		      	<h3><?php echo __('Active Deals'); ?></h3>
		      	<?php echo __('Aktuell laufende Deals'); ?>
		      </div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
  					<?php echo __('Deals left');?>
  					<a href="#" class="helptip">
	          	<img src="/img/qus_icon.png" alt="<?php echo __("Deals left"); ?>" class="tooltip-icon" />
	          </a>
  				</div>
          <div class="tooltip">
          	<h3><?php echo __('Deals left'); ?></h3>
          	<?php echo __("Anzahl der noch verfügbaren Deals"); ?>
          </div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
  					<?php echo __('Days left');?>
  					<a href="#" class="helptip">
	          	<img src="/img/qus_icon.png" alt="<?php echo __("Days left"); ?>" class="tooltip-icon" />
	          </a>
  				</div>
          <div class="tooltip">
          	<h3><?php echo __('Days left'); ?></h3>
          	<?php echo __("Restlaufzeit des Deals"); ?>
          </div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
  					<?php echo __('Reach'); ?>
			  	  <a href="#" class="helptip">
		        	<img src="/img/qus_icon.png" alt="<?php echo __("Reach"); ?>" class="tooltip-icon" />
		        </a>
	  	  	</div>
	      	<div class="tooltip"><h3><?php echo __('Reach'); ?></h3><?php echo __('Maximale Reichweite der Empfehlung'); ?></div>
  			</th>
  	    <th align="center" valign="middle">
  	    	<div>
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
  	    	<div>
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
  		<?php
  		if ($deals) {
  		  foreach ($deals as $deal) {
  		?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo $deal->getSummary(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingCouponQuantity(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getRemainingDays() > 0 ? $deal->getRemainingDays() : __('expired'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getMediaPenetration() : 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbacks() : 0; ?></div></td>
  				<td align="center" valign="middle" class="last"><div><?php echo $deal->getDealSummary() ? $deal->getDealSummary()->getClickbackLikes() : 0; ?></div></td>
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