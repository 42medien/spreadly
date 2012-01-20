<section class="buttontabsection clearfix">
<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>
<form action="<?php echo url_for('deals/step_coupon?did='.$pDealId); ?>" name="deal_form" id="deal_form" method="POST">
<div class="alignright tabcontainer">
	<div id="tab3" class="tabcontent" >
		<div class="stepitem clearfix">
			<div class="alignleft leftpartguts">
				<h3 class="toptitle"><?php echo __('Schritt 3: Gutschein gestalten')?></h3>
				<div class="contentbox">
					<ul class="stepprolist clearfix">
						<li id="namegutscheins">
							<h3 class="steptitle"><span class="nu">1</span><?php echo $pForm['coupon_title']->renderLabel(); ?></h3>
							<p><?php echo __('Geben Sie Ihrem Gutschein einen Namen, der sich auf Ihr Angebot bezieht.'); ?></p>
							<label class="btnform-input">
								<?php echo $pForm['coupon_title']->render(array('class' => 'wd320', 'placeholder' => __('Amazon Gutschein von Spreadly'))); ?>
							</label>
							<span class="note"><?php echo __('<span id="coupon_title_counter">255</span> characters left'); ?></span>
							<?php echo $pForm['coupon_title']->renderError(); ?>
						</li>
						<li class="last" id="gutscheintext">
							<h3 class="steptitle"><span class="nu">2</span><?php echo $pForm['coupon_text']->renderLabel(); ?></h3>
							<p><?php echo __('Erklären Sie hier genau, wie der Teilnehmer an Ihr Angebot / den Gewinn kommt.'); ?></p>
							<label class="btnform-input">
								<?php echo $pForm['coupon_text']->render(array('class' => 'commentbox', 'placeholder' => __('Klicken Sie diesen Link um sich Ihren Amazon Gutschein herunter zu laden. Sie können diesen Gutschein uneingeschränkt nutzen und auch an Dritte weitergeben.'))); ?>
							</label>
							<span class="note"><?php echo __('<span id="coupon_text_counter">500</span> characters left'); ?></span>
							<?php echo $pForm['coupon_text']->renderError(); ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="alignright">
				<span class="preview-img">
					<?php if($pForm['coupon_type']->getValue()) {?>
						<img id="coupon-preview-img" src="/img/coupon_type_<?php echo $pForm['coupon_type']->getValue(); ?>.png" width="339px" />
					<?php } else { ?>
						<img id="coupon-preview-img" src="/img/coupon_type_code.png" width="339px" />
					<?php } ?>
				</span>
			</div>
		</div>


		<ul class="steplistwide clearfix">
			<li class="coupon-type-select">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><?php echo $pForm['coupon_type']->renderLabel(); ?></h3>
					<p><?php echo __('Bitte geben Sie hier die Art Ihres Angebots/Gewinns an'); ?></p>
				</div>
				<?php echo $pForm['coupon_type']->render(); ?>
			</li>


			<li <?php echo ($pForm['coupon_type']->getValue() == 'code' || $pForm['coupon_type']->getValue() == 'unique_code')? 'style="display:none;"':""; ?> id="coupon-url-row">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">3</span><?php echo $pForm['coupon_url']->renderLabel(); ?></h3>
					<p><?php echo __('Bitte geben Sie hier die URL ein, die zu Ihrem Angebot führt'); ?></p>
				</div>
				<div class="value alignleft">
					<label class="btnform-input">
						<?php echo $pForm['coupon_url']->render(); ?>
					</label>
					<?php echo $pForm['coupon_url']->renderError(); ?>
				</div>
			</li>

			<li <?php echo ($pForm['coupon_type']->getValue() != 'unique_code')? 'style="display:none;"':""; ?> id="coupon-webhook-row">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">3</span><?php echo $pForm['coupon_webhook_url']->renderLabel(); ?></h3>
					<p><?php echo __('Bitte geben Sie hier die URL ein, die zu Ihrer Code-API führt'); ?></p>
				</div>
				<div class="value alignleft">
					<label class="btnform-input">
						<?php echo $pForm['coupon_webhook_url']->render(); ?>
					</label>
					<?php echo $pForm['coupon_webhook_url']->renderError(); ?>
				</div>
			</li>

			<li <?php echo ($pForm['coupon_type']->getValue() != 'code')? 'style="display:none;"':""; ?> id="coupon-code-row">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">3</span><?php echo $pForm['coupon_code']->renderLabel(); ?></h3>
					<p><?php echo __('Bitte geben Sie hier Ihren Gutschein Code ein'); ?></p>
				</div>
				<div class="value alignleft">
					<label class="btnform-input">
						<?php echo $pForm['coupon_code']->render(array('placeholder' => 'IHRCODE')); ?>
					</label>
					<span class="note"><?php echo __('<span id="coupon_code_counter">255</span> characters left'); ?></span>
					<?php echo $pForm['coupon_code']->renderError(); ?>
				</div>
			</li>



			<li class="last" <?php echo ($pForm['coupon_type']->getValue() == 'code' || $pForm['coupon_type']->getValue() == 'unique_code')? '':'style="display:none;"'; ?> id="coupon-redeem-row">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">4</span><?php echo $pForm['coupon_redeem_url']->renderLabel(); ?></h3>
					<p><?php echo __('Bitte geben Sie hier die URL ein, die zu Ihrem Angebot führt'); ?></p>
				</div>
				<div class="value alignleft">
					<label class="btnform-input">
						<?php echo $pForm['coupon_redeem_url']->render(array('class' => 'wd320')); ?>
					</label>
					<?php echo $pForm['coupon_redeem_url']->renderError(); ?>
				</div>
			</li>
		</ul>
		<span class="btnbarlist"><label class="pink-btn"><input type="submit" value=<?php echo __('Weiter'); ?>></label></span>
	</div>
</div>
</form>
</section>