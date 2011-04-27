<?php use_helper("Text", "YiidNumber"); ?>

<?php if(count($pVerifiedDomains) > 0) { ?>
<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-website-table" class="tablesorter scrolltable" style="width: 930px;">
	  	<thead>
	    	<tr>
	  			<th align="center" valign="middle" class="first">
	  				<div class="sortlink no-sort">
	  					<?php echo __('Websites last 30 days'); ?>
	  	    	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Websites last 30 days"); ?>" class="tooltip-icon" />
          	</a>
	  	    	</div>
	         	<div class="tooltip"><h3><?php echo __('Websites last 30 days'); ?></h3><?php echo __('Aktivitäten auf Domains in den letzten 30 Tagen'); ?></div>
	  			</th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort"><?php echo __('Likes');?>
	  	    	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          	</a>
	  	    	</div>
	         	<div class="tooltip">
	         		<h3><?php echo __('Likes'); ?></h3>
	         		<?php echo __('Number of likes received for your content on your url.'); ?>
	         	</div>
	  	    </th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
	  	    		<?php echo __('Spreads');?>
		  	    	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" alt="<?php echo __("Spreads"); ?>" class="tooltip-icon" />
	          	</a>
	  	    	</div>
	         	<div class="tooltip"><h3><?php echo __('Spreads'); ?></h3><?php echo __('Total number of likes published in the social networks listed.'); ?></div>
	 	    	</th>
	  			<th align="center" valign="middle" class="last">
	  				<div class="sortlink no-sort" style="white-space: nowrap;">
	  					<?php echo __('Media Penetration'); ?>
	          	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" title="<?php echo __("Media Penetration"); ?>" alt="<?php echo __("Media Penetration"); ?>"  class="tooltip-icon" />
	          	</a>
	  				</div>
          	<div class="tooltip">
          		<h3><?php echo __('Media Penetration'); ?></h3>
          		<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>
          	</div>
	  			</th>
	    	</tr>
	    </thead>
	    <tbody class="scrollbody">
	  		<?php $i = 1;?>
	  		<?php foreach($pVerifiedDomains as $lDomain) { ?>
	  			<tr class="scrollrow">
	  				<td align="left" class="first"><div class="padleft"><?php echo link_to($lDomain->getUrl(), 'analytics/domain_statistics?domainid='.$lDomain->getId()); ?></div></td>
	  		    <td align="center" valign="middle"><div><?php echo array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['l']) : 0; ?></div></td>
	  		    <td align="center" valign="middle" ><div><?php echo array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['sh']) : 0; ?></div></td>
	  				<td align="center" class="last"><div><?php echo array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['mp']) : 0; ?></div></td>
	  			</tr>
	      <?php $i++; } ?>
	    </tbody>
    </table>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>

<?php if(count($pDeals) > 0) { ?>
<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-deal-table" class="tablesorter scrolltable" style="width: 930px;">
  	<thead>
    	<tr>
  			<th align="center" valign="middle" class="first">
  				<div class="sortlink no-sort">
  					<?php echo __('Deals last 30 days'); ?>
	          	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" title="<?php echo __("Deals last 30 days"); ?>" alt="<?php echo __("Deals last 30 days"); ?>"  class="tooltip-icon" />
	          	</a>
	  				</div>
          	<div class="tooltip">
          		<h3><?php echo __('Deals last 30 days'); ?></h3>
          		<?php echo __("Aktivitäten auf Deals in den letzten 30 Tagen"); ?>
          	</div>
  			</th>
  			<th align="center" valign="middle">
  				<div class="sortlink no-sort">
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
  				<div class="sortlink no-sort">
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
  	    	<div class="sortlink no-sort">
  	    		<?php echo __('Likes');?>
	  	    	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          	</a>
	  	    	</div>
	         	<div class="tooltip">
	         		<h3><?php echo __('Likes'); ?></h3>
	         		<?php echo __('Number of likes received for your content on your url.'); ?>
	         	</div>
  	    </th>
  	    <th align="center" valign="middle">
  	    	<div class="sortlink no-sort">
  	    		<?php echo __('Shares');?>
		  	    	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" alt="<?php echo __("Spreads"); ?>" class="tooltip-icon" />
	          	</a>
	  	    	</div>
	         	<div class="tooltip"><h3><?php echo __('Spreads'); ?></h3><?php echo __('Total number of likes published in the social networks listed.'); ?></div>
  	    </th>
  			<th align="center" valign="middle" class="last">
  				<div class="sortlink no-sort" style="white-space: nowrap;">
  					<?php echo __('Media Penetration'); ?>
	          	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" title="<?php echo __("Media Penetration"); ?>" alt="<?php echo __("Media Penetration"); ?>"  class="tooltip-icon" />
	          	</a>
	  				</div>
          	<div class="tooltip">
          		<h3><?php echo __('Media Penetration'); ?></h3>
          		<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>
          	</div>
  			</th>
    	</tr>
    </thead>
    <tbody>
  		<?php $i = 1;?>
  		<?php foreach($pDeals as $lDeal) { ?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo $lDeal->getSummary(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $lDeal->getRemainingCouponQuantity(); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo $lDeal->getRemainingDays() > 0 ? $lDeal->getRemainingDays() : __('expired'); ?></div></td>
  				<td align="center" valign="middle"><div><?php echo array_key_exists($lDeal->getId(), $last30ByDeal) ? point_format($last30ByDeal[$lDeal->getId()]['value']['l']) : 0; ?></div></td>
  				<td align="center" valign="middle"><div><?php echo array_key_exists($lDeal->getId(), $last30ByDeal) ? point_format($last30ByDeal[$lDeal->getId()]['value']['sh']) : 0; ?></div></td>
  				<td align="center" class="last"><div><?php echo array_key_exists($lDeal->getId(), $last30ByDeal) ? point_format($last30ByDeal[$lDeal->getId()]['value']['mp']) : 0; ?></div></td>
  			</tr>
      <?php $i++; } ?>
    	</tbody>
  	</table>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>


<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-url-table" class="tablesorter scrolltable" style="width: 930px;">
	  	<thead>
	    	<tr>
	  			<th align="center" valign="middle" class="first">
	  				<div class="sortlink no-sort">
	  					<?php echo __('Top-Pages last 30 days'); ?>
	          	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" title="<?php echo __("Top-Pages last 30 days"); ?>" alt="<?php echo __("Top-Pages last 30 days"); ?>"  class="tooltip-icon" />
	          	</a>
	  				</div>
          	<div class="tooltip">
          		<h3><?php echo __('Top-Pages last 30 days'); ?></h3>
          		<?php echo __("Aktivste Seiten in den letzten 30 Tagen"); ?>
          	</div>
	  			</th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
	  	    		<?php echo __('Likes');?>
	  	    	<a href="#" class="helptip">
          		<img src="/img/qus_icon.png" alt="<?php echo __("Likes"); ?>" class="tooltip-icon" />
          	</a>
	  	    	</div>
	         	<div class="tooltip"><h3><?php echo __('Likes'); ?></h3><?php echo __('Number of likes received for your content on your url.'); ?></div>
	  	    </th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
	  	    		<?php echo __('Shares');?>
		  	    	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" alt="<?php echo __("Spreads"); ?>" class="tooltip-icon" />
	          	</a>
	  	    	</div>
	         	<div class="tooltip"><h3><?php echo __('Spreads'); ?></h3><?php echo __('Total number of likes published in the social networks listed.'); ?></div>
	  	    </th>
	  			<th align="center" valign="middle" class="last">
	  				<div class="sortlink no-sort" style="white-space: nowrap;">
	  					<?php echo __('Media Penetration'); ?>
	          	<a href="#" class="helptip">
	          		<img src="/img/qus_icon.png" title="<?php echo __("Media Penetration"); ?>" alt="<?php echo __("Media Penetration"); ?>"  class="tooltip-icon" />
	          	</a>
	  				</div>
          	<div class="tooltip">
          		<h3><?php echo __('Media Penetration'); ?></h3>
          		<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>
          	</div>
	  			</th>
	    	</tr>
	    </thead>
	    <tbody class="scrollbody">
	    	<?php if(count($last30ByUrl) > 0) { ?>
	  		<?php $i = 1;?>
	  		<?php foreach($last30ByUrl as $lUrl) { ?>
	  		  <?php $lUrlValue = $lUrl['value'] ?>
	  			<tr class="scrollrow">
	  				<td align="left" class="first">
	  					<div class="padleft">
	  						<?php echo link_to(truncate_text($lUrl['_id'], 60), $lUrl['_id'], array('target' => '_blank') ); ?>
	  					</div>
	  				</td>
	  		    <td align="center" valign="middle"><div><?php echo point_format($lUrlValue['l']) ?></div></td>
	  		    <td align="center" valign="middle" ><div><?php echo point_format($lUrlValue['sh']) ?></div></td>
	  				<td align="center" class="last"><div><?php echo point_format($lUrlValue['mp']) ?></div></td>
	  			</tr>
	      <?php $i++; } ?>
	      <?php } else { ?>
	  			<tr class="scrollrow">
	  				<td align="center" colspan="4"><?php echo __('No websites claimed');?></td>
	  			</tr>
	      <?php } ?>
	    </tbody>
    </table>
  </div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
