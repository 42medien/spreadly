
<section class="buttontabsection clearfix">
<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>
<form action="<?php echo url_for('deals/step_share?did='.$pDealId); ?>" id="deal_form" name="create_deal_form" method="POST">
<div class="alignright tabcontainer">
	<div id="tab2" class="tabcontent" >
		<div class="stepitem dealing clearfix">
			<div class="alignleft leftpartguts">
				<h3 class="toptitle"><?php echo __('Schritt 2: Deal definieren')?></h3>
				<div class="contentbox">
					<ul class="stepprolist clearfix">
						<li id="motivator">
							<h3 class="steptitle"><span class="nu">1</span><?php echo $pForm['motivation_title']->renderLabel(); ?></h3>
							<p><?php echo __('Fordern Sie explizit zur Teilnahme an Ihrem Deal auf. Diese Aufforderung erscheint im Like-Popup und soll Ihre Zielgruppe zum Teilnehmen motivieren.'); ?></p>
							<label class="btnform-input"><?php echo $pForm['motivation_title']->render(array('placeholder' => __('20 € für Ihren Like!'))); ?></label>
							<span class="note"><?php echo __('<span id="motivation_title_counter">255</span> characters left'); ?></span>
							<?php echo $pForm['motivation_title']->renderError(); ?>
						</li>
						<li class="last" id="motivetext">
							<h3 class="steptitle"><span class="nu">2</span><?php echo $pForm['motivation_text']->renderLabel(); ?></h3>
							<p><?php echo __('Adressieren Sie Ihre Zielgruppe und erklären Sie, wieso Ihr Angebot attraktiv ist und welchen Vorteil Teilnehmer konkret erwarten.'); ?></p>
							<label class="btnform-input">
								<?php echo $pForm['motivation_text']->render(array('class' => 'commentbox', 'placeholder' => __('Ihr Like ist uns Geld wert. Sie erhalten für Ihren Like einen 20 Euro Amazon Gutschein! Like klicken und danach sofort Gutschein herunterladen.'))); ?>
							</label>
							<span class="note"><?php echo __('<span id="motivation_text_counter">500</span> characters left'); ?></span>
							<?php echo $pForm['motivation_text']->renderError(); ?>
						</li>
					</ul>
				</div>
			</div>
			<div class="alignright">
				<span class="preview-img"><img src="/img/statistics/dealview-img.jpg" alt="deal-preview" title="deal-preview"></span>
			</div>
		</div>
		<ul class="steplistwide clearfix">
			<li id="spreadwerbung">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">3</span><?php echo $pForm['spread_title']->renderLabel(); ?></h3>
					<p><?php echo __('Legen Sie die Überschrift fest für das Angebot oder Produkt, das Sie mit Ihrer Kampagne bewerben möchten. Dieser Spread erscheint in den vom Teilnehmer gewählten Zielnetzwerken (z.B. Facebook).'); ?></p>
				</div>
				<div class="value alignright">
					<label class="btnform-input">
						<?php echo $pForm['spread_title']->render(array('placeholder' => __('DozentenScout: Marktplatz für Weiterbildung'))); ?>
					</label>
					<span class="note"><?php echo __('<span id="spread_title_counter">255</span> characters left'); ?></span>
					<?php echo $pForm['spread_title']->renderError(); ?>
				</div>
			</li>
			<li id="spreadteaser">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">4</span><?php echo $pForm['spread_text']->renderLabel(); ?></h3>
					<p><?php echo __('Hier ist Platz für Ihre Werbebotschaft.'); ?></p>
				</div>
				<div class="value alignright">
					<label class="btnform-input">
						<?php echo $pForm['spread_text']->render(array('class' => 'commentbox', 'placeholder' => __('Seminare und Trainer finden, Jobs ausschreiben, Fachartikel aus der Weiterbildungsbranche lesen.'))); ?>
					</label>
					<span class="note"><?php echo __('<span id="spread_text_counter">500</span> characters left'); ?></span>
					<?php echo $pForm['spread_text']->renderError(); ?>
				</div>
			</li>
			<li>
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">5</span><?php echo $pForm['spread_url']->renderLabel(); ?></h3>
					<p><?php echo __('Hier erscheint die URL, die Sie bewerben möchten.'); ?></p>
				</div>
				<div class="value alignright">
					<label class="btnform-input">
						<?php echo $pForm['spread_url']->render(array('placeholder' => __('http://www.dozentenscout.de/'))); ?>
					</label>
					<?php echo $pForm['spread_url']->renderError(); ?>
				</div>
			</li>
			<li>
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">6</span><?php echo $pForm['spread_img']->renderLabel(); ?></h3>
					<p><?php echo __('Geben Sie hier die URL zu einem Bild ein, das mit Ihrem Angebot / Produkt erscheinen soll. Mit Bild ist Ihre Werbung ein Blickfang.'); ?></p>
				</div>
				<div class="value alignright">
					<label class="btnform-input">
						<?php echo $pForm['spread_img']->render(array('placeholder' => __('http://www.dozentenscout.de/img/logo-dozentenscout.png'))); ?>
					</label>
					<?php echo $pForm['spread_img']->renderError(); ?>
				</div>
			</li>
			<li class="last">
				<div class="alignleft labelvalue">
					<h3 class="steptitle"><span class="nu">7</span><?php echo $pForm['spread_tos']->renderLabel(); ?></h3>
					<p><?php echo __('Geben Sie hier den Link zu Ihren AGB ein, die für Ihr Angebot gelten.'); ?></p>
				</div>
				<div class="value alignright">
					<label class="btnform-input">
						<?php echo $pForm['spread_tos']->render(array('placeholder' => __('http://www.dozentenscout.de/static/AGB'))); ?>
					</label>
					<?php echo $pForm['spread_tos']->renderError(); ?>
				</div>
			</li>
		</ul>
		<span class="btnbarlist"><label class="pink-btn"><input type="submit" value="<?php echo __('Weiter'); ?>"></label></span>
	</div>
</div>
</form>
</section>