<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_share?did='.$pDealId); ?>" id="deal_form" name="create_deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<div class="alignright">
		<img src="/img/popup-deal.png" width="400px" />
		<!-- screen von deal-like -->
	</div>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 2: Configure share')?></h2>
		<ul class="btnformlist">
	  	<li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['motivation_title']->renderLabel(); ?></strong><span><?php echo __('Explain what motivation title is...'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['motivation_title']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="counter-box clearfix"><?php echo __('<span id="motivation_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['motivation_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['motivation_text']->renderLabel(); ?></strong><span><?php echo __('Explain what motivation text is...'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['motivation_text']->render(array('class' => 'wd320')); ?>
								</label>
							</div>
						</div>
						<div class="textaria_bot"><span>&nbsp;</span></div>
				</div>
				<div class="counter-box clearfix"><?php echo __('<span id="motivation_text_counter">500</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['motivation_text']->renderError(); ?>	</div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_title']->renderLabel(); ?></strong><span><?php echo __('Explain what the spread title does'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_title']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="counter-box clearfix"><?php echo __('<span id="spread_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_text']->renderLabel(); ?></strong> <span><?php echo __('Explain what the spread text does'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['spread_text']->render(array('class' => 'wd320')); ?>
								</label>
							</div>
						</div>
						<div class="textaria_bot"><span>&nbsp;</span></div>
				</div>
				<div class="counter-box clearfix"><?php echo __('<span id="spread_text_counter">500</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_text']->renderError(); ?>	</div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_url']->renderLabel(); ?></strong><span><?php echo __('Explain what the spread url is'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_url']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_url']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_img']->renderLabel(); ?></strong><span><?php echo __('Explain what the spread img is'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_img']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_img']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_tos']->renderLabel(); ?></strong><span><?php echo __('Explain what the spread tos are'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_tos']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_tos']->renderError(); ?></div>
			</li>
		</ul>
		<input type="submit" id="create_deal_button" value="<?php echo __('Go to next step'); ?>" class="button alignright" />
	</div>
</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>




