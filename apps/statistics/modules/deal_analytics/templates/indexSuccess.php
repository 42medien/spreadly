<div class="page-titlecontent">
	<h2><?php echo __('Kampagnen-Analytics'); ?></h2>
	<p><?php echo __('Hier sehen Sie eine Übersicht der von Ihnen gestarteten Kampagnen im Spreadly Ad-Network. Klicken Sie auf einen Kampagnennamen um die entsprechenden Details einsehen zu können.'); ?></p>
</div>

<?php use_helper("Text", "YiidNumber"); ?>
<?php if(count($pDeals) > 0) { ?>
<?php slot('content') ?>
  <div class="data-tablebox">
  	<table border="0" cellspacing="0" cellpadding="0" id="dash-deal-table" class="tablesorter scrolltable" style="width: 925px;">
  	<thead>
    	<tr>
  			<th align="center" valign="middle" class="first">
  				<div class="sortlink no-sort">
						<span class="myqtip" title="<?php echo __("Name der Kampagne"); ?>">
	  					<?php echo __('Campains'); ?>
	  				</span>
  				</div>
  			</th>
  			<th align="center" valign="middle">
  				<div class="sortlink no-sort">
						<span class="myqtip" title="<?php echo __("Anzahl der noch verfügbaren Deals"); ?>">
  						<?php echo __('Deals left');?>
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
    <tbody>
  		<?php foreach($pDeals as $lDeal) { ?>
  			<tr>
  				<td align="left" class="first"><div class="padleft"><?php echo link_to($lDeal->getName(), 'deal_analytics/deal_statistics?deal_id='.$lDeal->getId()); ?></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $lDeal->getRemainingQuantity(); ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $lDeal->getLikes(); ?></strong></div></td>
  				<td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $lDeal->getShares(); ?></strong></div></td>
  				<td align="center" class="last"><div><strong class="big-font blue"><?php echo $lDeal->getMediaPenetration(); ?></strong></div></td>
  			</tr>
      <?php } ?>
    	</tbody>
  	</table>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<?php } ?>

<div class="page-titlecontent">
	<h2><?php echo __('Werbe-Statistiken'); ?></h2>
	<p><?php echo __('Hier finden sie in Zukunft die Statistiken zu der von Ihnen geschalteten Werbe-Layer.'); ?></p>
</div>
<?php slot('content') ?>
coming soon...
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

<?php include_partial('global/spreadly_references');?>