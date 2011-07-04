  <table width="930px;" border="0" cellspacing="0" cellpadding="0" id="top-influencer-table" class="tablesorter">
  <thead>
    <tr>
      <th align="center" valign="middle" class="first">
      	<div class="sortlink no-sort">
      		<span class="myqtip" title="<?php echo __('Name of the influencer'); ?>">
      			<?php echo __('Influencer'); ?>
      		</span>
      	</div>
      </th>
      <th align="center" valign="middle">
      	<div class="sortlink">
					<span class="myqtip" title="<?php echo __('Überblick Altersgruppen der Empfehler'); ?>">
      			<?php echo __('Age');?>
      		</span>
	  	  </div>
      </th>
      <th align="center" valign="middle">
      	<div class="sortlink">
      		<span class="myqtip" title="<?php echo __('Überblick Geschlecht der Empfehler'); ?>">
      			<?php echo __('Gender');?>
      		</span>
	  	  </div>
      </th>
      <th align="center" valign="middle">
      	<div class="sortlink">
      		<span class="myqtip" title="<?php echo __('Überblick Beziehungsstatus der Empfehler'); ?>">
      			<?php echo __('Relationship');?>
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
    <?php
    if ($pUrls->hasNext()) {
      foreach($pUrls as $url) {
        $user = UserTable::getInstance()->find($url->getUserId());
    ?>
      <tr>
        <td align="center" valign="middle" class="first"><div class="infname"><span><?php echo image_tag($user->getAvatar(), array("alt" => $user->getFullname(), "width" => 16, "height" => 16)); ?><?php echo $user->getFullname(); ?></span></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $url->getAge() ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo __($url->getGender()) ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo __($url->getRelationship()) ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($url->getShares()) ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo point_format($url->getMediaPenetration()) ?></strong></div></td>
        <td align="center" valign="middle"><div><strong class="big-font blue"><?php echo $url->getClickbacks() ? point_format($url->getClickbacks()) : 0 ?></strong></div></td>
        <td align="center" valign="middle" class="last"><div><strong class="big-font blue"><?php echo ($url->countClickbackLikes())?$url->countClickbackLikes():0; ?></strong></div></td>
      </tr>
    <?php
      }
    } else {
    ?>
      <tr><td align="center" colspan="8"><?php echo __("No likes yet"); ?></td></tr>
    <?php } ?>
    </tbody>
  </table>