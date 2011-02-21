		<div class="contentbox">
			<div class="grboxtop"><span></span></div>
			<div class="grboxmid midcontent">
				<div class="grboxmid-content">
					<div class="graybox clearfix">
						<div>
							<div class="alignright help_content step2_content">
								<h3 class="title">Lorem Help</h3>
								<p>Lorem ipsum at virtute delenit intellegam vim, eos no alii pertinax ocurreret. An affert regione civibus per, et atqui sonet ceteros sit, magna nemore constituam ex nec. </p>
								<p>Eu ius aliquid impeditrepudiandae, mei illum aliquam et, sea ne putant feugait. Verear alterum fabellas eam ea, nam deleniti offendit similique ut. Mea at ornatus nominati.</p>
								<p>Lusto lucilius vituperatoribus eam ut. Sint nemore eam ei, efficiendi neglegentur voluptatibus.</p>
							</div>
							<div class="alignleft stylestatus_box">
								<h3 class="sub_title"><?php echo __('Step 2: Choose Site & Style'); ?></h3>
								<div class="innerloginbox">
									<form action="" name="likebutton-form" id="likebutton-form">
      						<?php if($pService) {?>
        						<input type="hidden" name="likebutton[service]" value="<?php echo $pService->getSlug(); ?>"/>
        					<?php } ?>

										<fieldset class="group">
											<div class="clearfix">
											<label class="textfield"><span>
												<input type="text" class="wd183" name="likebutton[url]" id="likebutton_url" value="" />
												</span>
											</label>
										</div>
										<div class="stylechoose_box clearfix" id="preview_widgets">
											<?php //include_partial('configurator/preview_widgets'); ?>
										</div>
										<div class="select_label">
											<span class="tag">Choose Language (for PopUp):</span>
											<label id="http-sel">
									      <select name="likebutton[l]" id="likebutton_l" class="custom-select">
									        <option value="de" selected="selected"><?php echo __('SELECT_LANGUAGE_DE', null, 'configurator'); ?></option>
									        <option value="en"><?php echo __('SELECT_LANGUAGE_EN', null, 'configurator'); ?></option>
									      </select>
											</label>
										</div>
										</fieldset>
									</form>
								</div>
							</div>
							<div class="alignleft grabcode_box">
								<h3 class="sub_title">Step 3: Grab Your Code</h3>
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
									<div class="copycodebox clearfix"> <a href="#" title="Copy code" class="graybtn alignleft"><span>Copy code</span></a><span class="optionltext">Optional: register to get your statistics, it's free!</span> </div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="grboxbot"><span></span></div>
		</div>