<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_coupon?did='.$pDealId); ?>" name="deal_form" id="deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<div class="alignright">
		<img src="/img/popup-coupon.png" width="400px" />
		<!-- screen von deal-like -->
	</div>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Schritt 3: Gutschein gestalten')?></h2>
		<ul class="btnformlist">
	  	<li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_title']->renderLabel(); ?></strong><span><?php echo __('Geben Sie Ihrem Gutschein einen Namen, der sich auf Ihr Angebot bezieht.'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_title']->render(array('class' => 'wd320', 'placeholder' => __('Amazon Gutschein von Spreadly'))); ?>
					</span>
				</label>
				<div class="counter-box left-counter-box clearfix"><?php echo __('<span id="coupon_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['coupon_text']->renderLabel(); ?></strong><span><?php echo __('Erklären Sie hier genau, wie der Teilnehmer an Ihr Angebot / den Gewinn kommt.'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['coupon_text']->render(array('class' => 'wd320', 'placeholder' => __('Klicken Sie diesen Link um sich Ihren Amazon Gutschein herunter zu laden. Sie können diesen Gutschein uneingeschränkt nutzen und auch an Dritte weitergeben.'))); ?>
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
	      	<strong><?php echo $pForm['coupon_type']->renderLabel(); ?></strong><span><?php echo __('Bitte geben Sie hier die Art Ihres Angebots/Gewinns an'); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['coupon_type']->render(); ?>
	      </span><br/>
	      <span><?php echo $pForm['coupon_type']->renderError(); ?></span>
	    </li>


	  	<li class="clearfix" <?php echo ($pForm['coupon_type']->getValue() == 'code')? 'style="display:none;"':""; ?> id="coupon-url-row">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_url']->renderLabel(); ?></strong><span><?php echo __('Bitte geben Sie hier die URL ein, die zu Ihrem Angebot führt'); ?></span>
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
	      	<strong><?php echo $pForm['coupon_code']->renderLabel(); ?></strong><span><?php echo __('Bitte geben Sie hier Ihren Gutschein Code ein'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_code']->render(array('class' => 'wd320', 'placeholder' => 'IHRCODE')); ?>
					</span>
				</label>
				<div class="counter-box left-counter-box clearfix"><?php echo __('<span id="coupon_code_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_code']->renderError(); ?></div>
			</li>
	  	<li class="clearfix" <?php echo ($pForm['coupon_type']->getValue() != 'code')? 'style="display:none;"':""; ?> id="coupon-redeem-row">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['coupon_redeem_url']->renderLabel(); ?></strong><span><?php echo __('Bitte geben Sie hier die URL ein, die zu Ihrem Angebot führt'); ?></span>
	      </div>
	      <label class="textfield-wht">
		      <span>
		      	<?php echo $pForm['coupon_redeem_url']->render(array('class' => 'wd320')); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['coupon_redeem_url']->renderError(); ?></div>
			</li>


		</ul>
		<input type="submit" id="create_deal_button" value="<?php echo __('Weiter'); ?>" class="alignright" />
	</div>
</form>

<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>