          	<div class="graybox clearfix">
            	<div class="whtboxtopwide">
            		<div class="rcor">
              		<ul class="clearfix profileinfo">
                		<li class="prothumb">
                			<img src="/img/macrco-thumb.jpg" width="64" height="64" alt="Marco Ripanti" title="Marco Ripanti" />
                		</li>
                  	<li class="pronameblock">
                  		<h1><?php echo $pUser->getUsername(); ?></h1>Entrepreneur and founder of yiid.com
                  		<div class="scicon"><a href="#"><img src="/img/tweet-profilleicon.gif" width="17" height="17" alt="Twitter" title="Twitter" /></a><a href="#"><img src="/img/facebookprofileicon.gif" width="17" height="17" alt="Facebook" title="Facebook" /></a><a href="#"><img src="/img/in-profileicon.gif" width="17" height="17" alt="Linked in" title="Linked in" /></a><a href="#"><img src="/img/googlechat-icon.gif" width="19" height="17" alt="Buzz" title="Buzz" /></a></div>
										</li>
										<li class="friends-box">
											<div class="totalfriend">
												<span>12415</span><br />friends
											</div>
											Influencer
										</li>
                  </ul>
                </div>
              </div>

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
	                    		<label class="radio-btn">
	                    			<input type="checkbox" class="checkbox" name="" />
	                    		</label>
	                    		<a href="#">
	                    			<span>
	                    				<img src="/img/tweet-profilleicon.gif" width="17" height="17" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" />
	                    			</span>twitter.com/ripanti
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
                    <div class="morecomments alignright">
                    	Add more accounts: <a href="#"><img src="/img/facebookprofileicon.gif" width="17" height="17" alt="Facebook" title="Facebook" /></a><a href="#"><img src="/img/tweet-profilleicon.gif" width="17" height="17" alt="Twitter" title="Twitter" /></a><a href="#"><img src="/img/in-profileicon.gif" width="17" height="17" alt="Linked in" title="Linked in" /></a><a href="#"><img src="/img/googlechat-icon.gif" width="19" height="17" alt="Buzz" title="Buzz" /></a> </div>
                    </div>
                  </div>
                </div>
                <div class="whtboxbot">
                	<span></span>
                </div>
								<!-- end content -->