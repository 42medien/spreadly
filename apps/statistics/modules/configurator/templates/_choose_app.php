		<!--veryfied box start -->
		<div>
			<div class="grboxtop"><span></span></div>
			<div class="grboxmid">
				<div class="grboxmid-content">
					<div class="graybox clearfix">
						<div class="alignleft buttoncode_list">
							<h3 class="sub_title"><?php echo __("Step 1: Choose Type of Site"); ?></h3>
							<dl>
								<dd class="allweb-btn alignleft">
									<ul>
									<?php foreach($pServices as $lService) { ?>
									  <?php if($lService->getDownloadUrl()) { ?>
											<li>
												<a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank" class="service-img-link" id="service-img-<?php echo $lService->getSlug(); ?>"></a><span><a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank" title="<?php echo $lService->getName(); ?>"><?php echo $lService->getName(); ?></a></span>
											</li>
		    						<?php } elseif ($lService->getTutorialUrl()) { ?>
											<li>
												<a href="/configurator/get_choose_style?service=<?php echo $lService->getId();?>" class="config-app-link service-img-link" id="service-img-<?php echo $lService->getSlug(); ?>"></a><span><a href="/configurator/get_choose_style?service=<?php echo $lService->getId();?>" title="<?php echo $lService->getName(); ?>"  class="config-app-link"><?php echo $lService->getName(); ?></a></span>
											</li>
										<?php } ?>
									<?php } ?>
									</ul>
								</dd>
								<dd class="otherweb-box alignright">
									<ul>
										<li>
											<a href="/configurator/get_choose_style" class="config-app-link service-img-link" id="service-img-other"></a> <span><a href="/configurator/get_choose_style" title="Other websites" class="config-app-link"><?php echo __("Other websites"); ?></a></span>
										</li>
										<li><a href="/configurator/get_choose_style?service=static" class="config-app-link service-img-link" id="service-img-email"></a> <span><a href="/configurator/get_choose_style?service=static" class="config-app-link" title="Email &amp; Signatures"><?php echo __("Email & Signatures"); ?></a></span></li>
									</ul>
								</dd>
							</dl>
						</div>
						<div class="alignright help_content">
							<h3 class="title"><?php echo __("Help"); ?></h3>
							<p><?php echo __('Please choose the type of website you run or click "other websites" if it is missing. Select "Email & Signatures" to put the button in your newsletter or mailing.'); ?></p><br />
              <p><?php echo __("As extensions are offered for all common blog systems, implementing the button is made easy. Even when updates are made you do not have to bother as it adjusts automatically."); ?></p>
						</div>
					</div>
				</div>
			</div>
			<div class="grboxbot botspace"><span></span></div>
		</div>