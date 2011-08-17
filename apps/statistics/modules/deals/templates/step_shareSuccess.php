<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>

<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_share?did='.$pDealId); ?>" id="deal_form" name="create_deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>
	<div class="alignright">
		<img src="/img/popup-deal.png" width="400px" />
		<!-- screen von deal-like -->
	</div>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Schritt 2: Deal definieren')?></h2>
		<ul class="btnformlist">
	  	<li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['motivation_title']->renderLabel(); ?></strong><span><?php echo __('Fordern Sie explizit zur Teilnahme an Ihrem Deal auf. Diese Aufforderung erscheint im Like-Popup und soll Ihre Zielgruppe zum Teilnehmen motivieren.'); ?></span>
	      </div>
	      <label class="textfield-wht alignleft">
		      <span>
		      	<?php echo $pForm['motivation_title']->render(array('class' => 'wd320', 'placeholder' => __('20 € für Ihren Like!'))); ?>
					</span>
				</label>
				<div class="counter-box left-counter-box clearfix"><?php echo __('<span id="motivation_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['motivation_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['motivation_text']->renderLabel(); ?></strong><span><?php echo __('Adressieren Sie Ihre Zielgruppe und erklären Sie, wieso Ihr Angebot attraktiv ist und welchen Vorteil Teilnehmer konkret erwarten.'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['motivation_text']->render(array('class' => 'wd320', 'placeholder' => __('Ihr Like ist uns Geld wert. Sie erhalten für Ihren Like einen 20 Euro Amazon Gutschein! Like klicken und danach sofort Gutschein herunterladen.'))); ?>
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
					<strong><?php echo $pForm['spread_title']->renderLabel(); ?></strong><span><?php echo __('Legen Sie die Überschrift fest für das Angebot oder Produkt, das Sie mit Ihrer Kampagne bewerben möchten. Dieser Spread erscheint in den vom Teilnehmer gewählten Zielnetzwerken (z.B. Facebook).'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_title']->render(array('class' => 'wd320', 'placeholder' => __('DozentenScout: Marktplatz für Weiterbildung'))); ?>
					</span>
				</label>
				<div class="counter-box left-counter-box clearfix"><?php echo __('<span id="spread_title_counter">255</span> characters left'); ?></div>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_title']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_text']->renderLabel(); ?></strong> <span><?php echo __('Hier ist Platz für Ihre Werbebotschaft.'); ?></span>
				</div>
				<div class="alignleft">
					<div class="textaria_top"><span>&nbsp;</span></div>
						<div class="textaria_middle">
							<div class="textaria_right">
								<label class="textareablock">
									<?php echo $pForm['spread_text']->render(array('class' => 'wd320', 'placeholder' => __('Seminare und Trainer finden, Jobs ausschreiben, Fachartikel aus der Weiterbildungsbranche lesen.'))); ?>
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
					<strong><?php echo $pForm['spread_url']->renderLabel(); ?></strong><span><?php echo __('Hier erscheint die URL, die Sie bewerben möchten.'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_url']->render(array('class' => 'wd320', 'placeholder' => __('http://www.dozentenscout.de/'))); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_url']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_img']->renderLabel(); ?></strong><span><?php echo __('Geben Sie hier die URL zu einem Bild ein, das mit Ihrem Angebot / Produkt erscheinen soll. Mit Bild ist Ihre Werbung ein Blickfang.'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_img']->render(array('class' => 'wd320', 'placeholder' => __('http://www.dozentenscout.de/img/logo-dozentenscout.png'))); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_img']->renderError(); ?></div>
			</li>
			<li class="clearfix">
				<div class="btnwording alignleft">
					<strong><?php echo $pForm['spread_tos']->renderLabel(); ?></strong><span><?php echo __('Geben Sie hier den Link zu Ihren AGB ein, die für Ihr Angebot gelten.'); ?></span>
				</div>
				<label class="textfield-wht">
					<span>
						<?php echo $pForm['spread_tos']->render(array('class' => 'wd320', 'placeholder' => __('http://www.dozentenscout.de/static/AGB'))); ?>
					</span>
				</label>
				<div class="content-error-box clearfix"><?php echo $pForm['spread_tos']->renderError(); ?></div>
			</li>
		</ul>
		<input type="submit" id="create_deal_button" value="<?php echo __('Weiter'); ?>" class="button alignright" />
	</div>
</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>




