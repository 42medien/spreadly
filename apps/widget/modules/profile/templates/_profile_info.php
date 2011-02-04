            	<div class="whtboxtopwide">
            		<div class="rcor">
              		<ul class="clearfix profileinfo">
                		<li class="prothumb">
                			<img src="/img/macrco-thumb.jpg" width="64" height="64" alt="<?php echo $pUser->getUsername(); ?>" title="<?php echo $pUser->getUsername(); ?>" />
                		</li>
                  	<li class="pronameblock">
                  		<h1><?php echo $pUser->getUsername(); ?></h1><?php echo $pUser->getDescription(); ?>
                  		<div class="scicon">
                  		<?php foreach ($pIdentities as $lIdentity) { ?><a href="<?php echo url_for($lIdentity->getProfileUri()) ?>" target="_blank"><img src="/img/<?php echo $lIdentity->getCommunity()->getCommunity(); ?>-favicon.gif" width="17" height="17" alt="<?php echo $lIdentity->getName(); ?>" title="<?php echo $lIdentity->getName(); ?>" /></a><?php } ?>
                  		</div>
										</li>
										<li class="friends-box">
											<div class="totalfriend">
												<span><?php echo $pUser->getFriendCount(); ?></span><br /><?php echo __('friends'); ?>
											</div>
											<?php echo $pUser->getInfluencerRank(); ?>
										</li>
                  </ul>
                </div>
              </div>