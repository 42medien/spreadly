<?php use_helper("Text", "YiidNumber"); ?>

<?php if(count($pVerifiedDomains) > 0) { ?>
<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-website-table" class="tablesorter scrolltable" style="width: 910px;">
	  	<thead>
	    	<tr>
	  			<th align="center" valign="middle" class="first">
	  				<div class="sortlink no-sort">
	  	    		<span class="myqtip" title="<?php echo __('Aktivitäten auf Domains in den letzten 30 Tagen'); ?>">
	  						<?php echo __('Websites last 30 days'); ?>
          		</span>
	  	    	</div>
	  			</th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
							<span class="myqtip" title="<?php echo __('Number of likes received for your content on your url.'); ?>">
		  	    		<?php echo __('Likes');?>
	          	</span>
	  	    	</div>
	  	    </th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
							<span class="myqtip" title="<?php echo __('Total number of likes published in the social networks listed.'); ?>">
	  	    			<?php echo __('Spreads');?>
	  	    		</span>
	  	    	</div>
	 	    	</th>
	  			<th align="center" valign="middle">
	  				<div class="sortlink no-sort">
							<span class="myqtip" title="<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>">
	  						<?php echo __('Media Penetration'); ?>
	  					</span>
	  				</div>
	  			</th>
	  			<th align="center" valign="middle" class="last">
	  				<div class="sortlink no-sort" style="white-space: nowrap;">
							<span class="myqtip" title="<?php echo __("Your revenue of the last 30 days"); ?>">
	  						<?php echo __('Revenue'); ?>
	  					</span>
	  				</div>
	  			</th>
	    	</tr>
	    </thead>
	    <tbody class="scrollbody">
	  		<?php $i = 1;?>
	  		<?php foreach($pVerifiedDomains as $lDomain) { ?>
	  			<tr class="scrollrow">
	  				<td align="left" class="first"><div class="padleft"><?php echo link_to($lDomain->getUrl(), 'analytics/domain_statistics?domainid='.$lDomain->getId()); ?></div></td>
	  		    <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $last30ByHost && array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['l']) : 0; ?></strong></div></td>
	  		    <td align="center" valign="middle" ><div><strong class="big-font blue"><?php echo $last30ByHost && array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['sh']) : 0; ?></strong></div></td>
	  				<td align="center" class="middle"><div><strong class="big-font blue"><?php echo $last30ByHost && array_key_exists($lDomain->getUrl(), $last30ByHost) ? point_format($last30ByHost[$lDomain->getUrl()]['value']['mp']) : 0; ?></strong></div></td>
	  				<td align="center" class="last"><div><strong class="big-font blue"><?php echo $lDomain->getCommissionSumOfLast30Days() ? $lDomain->getCommissionSumOfLast30Days() : 0; ?> €</strong></div></td>
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
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-url-table" class="tablesorter scrolltable" style="width: 910px;">
	  	<thead>
	    	<tr>
	  			<th align="center" valign="middle" class="first">
	  				<div class="sortlink no-sort">
	  					<span class="myqtip" title="<?php echo __("Aktivste Seiten in den letzten 30 Tagen"); ?>">
		  					<?php echo __('Top-Pages last 30 days'); ?>
		  				</span>
	  				</div>
	  			</th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
	  	    		<span class="myqtip" title="<?php echo __('Number of likes received for your content on your url.'); ?>">
	  	    			<?php echo __('Likes');?>
	  	    		</span>
	  	    	</div>
	  	    </th>
	  	    <th align="center" valign="middle">
	  	    	<div class="sortlink no-sort">
	  	    		<span class="myqtip" title="<?php echo __('Total number of likes published in the social networks listed.'); ?>">
	  	    			<?php echo __('Shares');?>
	  	    		</span>
	  	    	</div>
	  	    </th>
	  			<th align="center" valign="middle" class="last">
	  				<div class="sortlink no-sort" style="white-space: nowrap;">
	  	    		<span class="myqtip" title="<?php echo __("Total number of contacts that are able to view the like referring to your content."); ?>">
	  						<?php echo __('Media Penetration'); ?>
	  					</span>
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
	  		    <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($lUrlValue['l']) ?></strong></div></td>
	  		    <td align="center" valign="middle" ><div><strong class="big-font blue"><?php echo point_format($lUrlValue['sh']) ?></strong></div></td>
	  				<td align="center" class="last"><div><strong class="big-font blue"><?php echo point_format($lUrlValue['mp']) ?></strong></div></td>
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
