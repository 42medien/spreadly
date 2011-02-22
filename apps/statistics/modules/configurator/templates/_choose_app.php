		<!--veryfied box start -->
		<div>
			<div class="grboxtop"><span></span></div>
			<div class="grboxmid">
				<div class="grboxmid-content">
					<div class="graybox clearfix">
						<div class="alignleft buttoncode_list">
							<h3 class="sub_title">Step 1: Choose Type of Site</h3>
							<dl>
								<dd class="allweb-btn alignleft">
									<ul>
									<?php foreach($pServices as $lService) { ?>
									  <?php if($lService->getDownloadUrl()) { ?>
											<li>
												<a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank"><img src="/img/<?php echo $lService->getSlug(); ?>-icon.png" width="51" height="51" alt="<?php echo $lService->getName(); ?>" title="<?php echo $lService->getName(); ?>" /></a><span><a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank" title="<?php echo $lService->getName(); ?>"><?php echo $lService->getName(); ?></a></span>
											</li>
		    						<?php } elseif ($lService->getTutorialUrl()) { ?>
											<li>
												<a href="/configurator/get_choose_style?service=<?php echo $lService->getId();?>" class="config-app-link"><img src="/img/<?php echo $lService->getSlug(); ?>-icon.png" width="51" height="51" alt="<?php echo $lService->getName(); ?>" title="<?php echo $lService->getName(); ?>" /></a><span><a href="/configurator/get_choose_style?service=<?php echo $lService->getId();?>" title="<?php echo $lService->getName(); ?>"  class="config-app-link"><?php echo $lService->getName(); ?></a></span>
											</li>
										<?php } ?>
									<?php } ?>
									</ul>
								</dd>
								<dd class="otherweb-box alignright">
									<ul>
										<li>
											<a href="/configurator/get_choose_style" class="config-app-link"><img src="/img/otherwebsite-icon.png" width="51" height="51" alt="Other websites" title="Other websites" /></a> <span><a href="/configurator/get_choose_style" title="Other websites" class="config-app-link">Other websites</a></span>
										</li>
										<li><a href="/configurator/get_choose_style?service=static" class="config-app-link"><img src="/img/email-msgicon.png" width="51" height="51" alt="Email &amp; Signatures" title="Email &amp; Signatures" /></a> <span><a href="/configurator/get_choose_style?service=static" class="config-app-link" title="Email &amp; Signatures">Email &amp; Signatures</a></span></li>
									</ul>
								</dd>
							</dl>
						</div>
						<div class="alignright help_content">
							<h3 class="title">Lorem Help</h3>
							<p>Lorem ipsum at virtute delenit intellegam vim, eos no alii pertinax ocurreret. An affert regione civibus per, et atqui sonet ceteros sit, magna nemore constituam ex nec. </p>
							<p>Eu ius aliquid impeditrepudiandae, mei illum aliquam et, sea ne putant feugait. Verear alterum fabellas eam ea, nam deleniti offendit similique ut. Mea at ornatus nominati.</p>
							<p>Lusto lucilius vituperatoribus eam ut. Sint nemore eam ei, efficiendi neglegentur voluptatibus.</p>
						</div>
					</div>
				</div>
			</div>
			<div class="grboxbot botspace"><span></span></div>
		</div>