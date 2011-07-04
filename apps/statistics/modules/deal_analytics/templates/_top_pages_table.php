<?php use_helper('Text', 'YiidUrl', "YiidNumber"); ?>
<div class="data-tablebox">
  <table border="0" width="930px;" cellspacing="0" cellpadding="0" id="top-url-table" class="tablesorter">
  	<thead>
    	<tr>
  			<th height="32" align="center" valign="middle" class="first">
  				<div>
	  	    		<span class="myqtip" title="<?php echo __('Top pages for this deal'); ?>">
  							<?php echo __('Pages'); ?>
  						</span>
		  	  </div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
	  	    	<span class="myqtip" title="<?php echo __("Redeemed deals on the page"); ?>">
  						<?php echo __('Deals');?>
  					</span>
  				</div>
  			</th>
  			<th align="center" valign="middle">
  				<div>
	  	    	<span class="myqtip" title="<?php echo __("Maximale Reichweite der Empfehlung"); ?>">
  						<?php echo __('Reach');?>
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
    if ($pUrls->hasNext()) {
      foreach($pUrls as $url){
    ?>
      <tr>
        <td height="44" align="left" class="first">
          <div class="padleft">
          	<?php if(isset($pShowUrl) && $pShowUrl) {?>
              <?php //echo range_sensitive_link_to(truncate_text($url->getUrl(), 60), 'analytics/url_detail', array('query_string' => 'domainid='.$pDomainProfile->getId().'&url='.urlencode($url->getUrl()))); ?>
            <?php } else { ?>
            		<?php echo truncate_text($url->getUrl(), 60); ?>
            <?php } ?>
          </div>
        </td>
        <td align="center"><div><strong class="big-font blue"><?php echo point_format($url->getLikes()); ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($url->getShares()); ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($url->getMediaPenetration()); ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($url->getClickbacks()); ?></strong></div></td>
        <td align="center" class="last"><div><strong class="big-font blue"><?php echo point_format($url->getClickbackLikes()); ?></strong></div></td>
      </tr>
    <?php
      }
    } else {
    ?>
      <tr><td align="center" colspan="6"><?php echo __("No urls yet"); ?></td></tr>
    <?php } ?>
    </tbody>
  </table>
</div>