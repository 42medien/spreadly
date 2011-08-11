<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_coupon?did='.$pDealId); ?>" name="deal_form" id="deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<div class="dealwidebox alignright">
		<!-- screen von deal-like -->
	</div>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 3: Configure your Coupon')?></h2>
		<ul class="btnformlist">
	  	<li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_title']->renderLabel(); ?></strong><span><?php echo __('Explain what the coupon title is'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_title']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="counter-box clearfix"><?php echo __('<span id="coupon_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['coupon_text']->renderLabel(); ?></strong><span><?php echo __('Explain what the coupon text is'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['coupon_text']->render(array('class' => 'wd320')); ?>
								</label>
							</div>
						</div>
						<div class="textaria_bot"><span>&nbsp;</span></div>
				</div>
				<div class="counter-box clearfix"><?php echo __('<span id="coupon_text_counter">500</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_text']->renderError(); ?>	</div>
			</li>

	    <li class="clearfix coupon-type-select">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_type']->renderLabel(); ?></strong><span><?php echo __('Explain what the coupon type is'); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['coupon_type']->render(); ?>
	      </span><br/>
	      <span><?php echo $pForm['coupon_type']->renderError(); ?></span>
	    </li>


	  	<li class="clearfix" <?php echo ($pForm['coupon_type']->getValue() == 'code')? 'style="display:none;"':""; ?> id="coupon-url-row">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_url']->renderLabel(); ?></strong><span><?php echo __('Explain what we mean with url or download url'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_url']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_url']->renderError(); ?></div>
			</li>


	  	<li class="clearfix" <?php echo ($pForm['coupon_type']->getValue() != 'code')? 'style="display:none;"':""; ?> id="coupon-code-row">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_code']->renderLabel(); ?></strong><span><?php echo __('Explain what a coupon code is for'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_code']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="counter-box clearfix"><?php echo __('<span id="coupon_code_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_code']->renderError(); ?></div>
			</li>
	  	<li class="clearfix" <?php echo ($pForm['coupon_type']->getValue() != 'code')? 'style="display:none;"':""; ?> id="coupon-redeem-row">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_redeem_url']->renderLabel(); ?></strong><span><?php echo __('Explain what the redeem url is for'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_redeem_url']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_redeem_url']->renderError(); ?></div>
			</li>


		</ul>
		<input type="submit" id="create_deal_button" value="<?php echo __('Go to next step'); ?>" class="alignright" />
	</div>
</form>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>