<?php use_helper('Text'); ?>
							<?php include_component('profile', 'profile_info'); ?>

              <div class="wht-contentbox clearfix">
              	<div class="whtboxpad">
                	<div class="fs13 clearfix">
                		<strong><?php echo __('Social Networks'); ?></strong>
                    <span class="postedrow"><?php echo __('Likes will be posted immediately to the networks you have checked:'); ?></span>
                  </div>
                  <div class="abonnementsbox clearfix">
                  	<ul class="azchecklist settingicon alignleft">
											<?php foreach ($pIdentities as $lIdentity) { ?>
	                    	<li>
	                    		<label class="radio-btn check-service">
	                    			<input type="checkbox" value="<?php echo $lIdentity->getId(); ?>" class="checkbox" name="" <?php echo $lIdentity->getSocialPublishingEnabled()?"checked=checked":''; ?>/>
	                    		</label>
	                    		<a href="<?php echo url_for($lIdentity->getProfileUri()) ?>" target="_blank">
	                    			<span>
	                    				<img src="/img/<?php echo $lIdentity->getCommunity()->getCommunity(); ?>-favicon.gif" width="17" height="17" alt="<?php echo $lIdentity->getCommunity()->getCommunity(); ?>" title="<?php echo $lIdentity->getCommunity()->getCommunity(); ?>" />
	                    			</span><?php echo $lIdentity->getName(); ?>
	                    		</a>
	                    	</li>
											<?php } ?>


                    	<li>
                    		<label class="radio-btn">
                    			<input type="checkbox" class="checkbox" name="" />
                    		</label>
                    		<a href="#">
                    			<span>
                    				<img src="/img/tweet-profilleicon.gif" width="17" height="17" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" />
                    			</span>twitter.com/ripanti
                    		</a>
                    	</li>
                      <li>
                      	<label class="radio-btn">
                      		<input type="checkbox" class="checkbox" name="" />
                      	</label>
                      	<a href="#">
                      		<span>
                      			<img src="/img/facebookprofileicon.gif" width="17" height="17" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" />
                      		</span>facebook.com/ripanti
                      	</a>
                      </li>
                      <li>
                      	<label class="radio-btn">
                      		<input type="checkbox" class="checkbox" name="" />
                      	</label>
                      	<a href="#">
                      		<span>
                      			<img src="/img/in-profileicon.gif" width="17" height="17" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" />
                      		</span>inkedin.com/ripanti
                      	</a>
                      </li>
                      <li>
                      	<label class="radio-btn">
                      		<input type="checkbox" class="checkbox" name="" />
                      	</label>
                      	<a href="#">
                      		<span>
                      			<img src="/img/googlechat-icon.gif" width="19" height="17" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" />
                      		</span>google.com/p/ripanti
                      	</a>
                      </li>
                    </ul>
                    <div class="morecomments add alignright">
                    	Add more accounts: <?php echo link_to(image_tag("/img/facebook-add.gif"), "@signinto?service=facebook&r=s"); ?><?php echo link_to(image_tag("/img/twiiter-add.gif"), "@signinto?service=twitter&r=s"); ?><?php echo link_to(image_tag("/img/in-add.gif"), "@signinto?service=linkedin&r=s"); ?><?php echo link_to(image_tag("/img/buzz-add.gif"), "@signinto?service=google&r=s"); ?></div>
                    </div>
                  </div>
                </div>
                <div class="whtboxbot">
                	<span></span>
                </div>
								<!-- end content -->