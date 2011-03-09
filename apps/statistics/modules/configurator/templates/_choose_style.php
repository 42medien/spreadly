		<div class="contentbox">
			<div class="grboxtop"><span></span></div>
			<div class="grboxmid midcontent">
				<div class="grboxmid-content">
					<div class="graybox clearfix">
						<div>
							<div class="alignright help_content step2_content">
								<h3 class="title"><?php echo __("Help"); ?></h3>
								<p><?php echo __("Please provide the exact web address. This URL should point to the location wanted for your Spread.ly button. Then chose your style and decide whether you like the button with pictures or not."); ?></p><br />
                <p><?php echo __("Your individual code will now appear in the box. Click “Copy code” to insert your Spread.ly button."); ?></p>
							</div>
							<div class="alignleft stylestatus_box">
								<h3 class="sub_title"><?php echo __('Step 2: Choose Site & Style'); ?></h3>
								<div class="innerloginbox">
									<form action="" name="likebutton-form" id="likebutton-form">
      						<?php if($pService) {?>
        						<input type="hidden" name="likebutton[service]" value="<?php echo $pService->getSlug(); ?>"/>
        					<?php } ?>

										<fieldset class="group">
										<?php if (!$pService || $pService->getSlug() == 'static') {?>
											<div class="clearfix">
												<label class="textfield"><span>
													<input type="text" class="wd183" name="likebutton[url]" id="likebutton_url" value="<?php echo __('Url of your site e.g. http://www.domain.com"'); ?>" />
													</span>
												</label>
											</div>
										<?php } else { ?>
											<div class="clearfix">
												<label class="textfield"><span>
													<input type="text" class="wd183" name="service_no_url" id="service_no_url" value="<?php echo __('Your '.$pService->getName().' Permalink'); ?>" readonly/>
													</span>
												</label>
											</div>
										<?php } ?>
										<div class="stylechoose_box clearfix">
											<div class="group radiobtn_list alignleft">
												<?php if(!$pService || ($pService && !($pService->getSlug() == 'static'))) { ?>
													<label for="radio1">&nbsp;</label><input id="radio1" type="radio" name="likebutton[wt]" value="short" class="widget-radio" <?php if(!isset($pSocial) || $pSocial == 0){ ?>checked="checked"<?php } ?>/>
												<?php } ?>
												<label for="radio2">&nbsp;</label><input id="radio2" type="radio" name="likebutton[wt]" value="stand_social" class="widget-radio" <?php if((isset($pSocial) && $pSocial == 1) || ($pService && $pService->getSlug() == 'static')){ ?>checked="checked"<?php } ?>/>
											</div>
											<div class="status_list alignleft" id="preview_widgets">
												<?php //include_partial('configurator/preview_widgets'); ?>
											</div>
										</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="alignleft grabcode_box">
								<h3 class="sub_title"><?php echo __('Step 3: Grab Your Code'); ?></h3>
								<div class="textariabox">
									<div class="textaria_top"><span>&nbsp;</span></div>
									<div class="textaria_middle">
										<div class="textaria_right">
											<label class="textareablock">
										    <textarea rows="10" cols="10" id="your_code"><?php //include_partial('configurator/widget_like') ?></textarea>
											</label>
										</div>
									</div>
									<div class="textaria_bot"><span>&nbsp;</span></div>
									<div class="copycodebox clearfix"> <a href="#" title="<?php echo __("Copy code"); ?>" class="graybtn alignleft" id="d_clip_container" style="position: relative;"><span id="d_clip_button"><?php echo __("Copy code"); ?></span></a><?php if(!$sf_user->isAuthenticated()){?><span class="optionltext"><?php echo link_to(__("Optional: register  to get your statistics, it's free!"), '@sf_guard_signin'); ?></span><?php } ?> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grboxbot"><span></span></div>
		</div>