<section class="buttontabsection clearfix">
<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>
<form action="<?php echo url_for('deals/step_verify?did='.$pDealId); ?>" name="create_deal_form" id="deal_verify_form" method="POST">
<div class="alignright tabcontainer">
	<div id="tab5" class="tabcontent prufen" style="display:block;">
		<div class="clearfix stepitem">
			<div class="alignleft leftpart first">
				<h3 class="toptitle"><?php echo __('Schritt 5: Prüfen')?></h3>
				<div class="contentbox">
					<h3>Kampagne anlegen</h3>
					<ul class="profiledetail-list clearfix">
						<li><span class="title"><?php echo __('Name'); ?>:</span><?php echo $pDeal->getName(); ?></li>
	    			<?php if ($pDeal->getBillingType() == 'like' ){ ?>
							<li><span class="title"><?php echo __('Streuung nach Likes'); ?>:</span><?php echo __($pDeal->getTargetQuantity().' Likes für '.$pDeal->getPrice()." Euro"); ?></li>
	    			<?php } else {?>
							<li><span class="title"><?php echo __('Streuung nach Reichweite'); ?>:</span><?php echo __($pDeal->getTargetQuantity().' erreichte User für '.$pDeal->getPrice()." Euro"); ?></li>
	    			<?php }?>
					  <?php if($pDeal->getType() == 'publisher') { ?>
							<li><span class="title"><?php echo __('Art des Deals'); ?>:</span><?php echo __("Domain-Deal"); ?></li>
					    <li class="last"><span class="title">
					    	<?php echo __('Domain'); ?>:</span>
					    	<?php $lDp = DomainProfileTable::getInstance()->find($pDeal->getDomainProfileId()); ?>
					    	<?php echo $lDp->getUrl(); ?>
					    </li>
					  <?php } else { ?>
							<li class="last"><span class="title"><?php echo __('Art des Deals'); ?></span>Pool-Deal</li>
					  <?php } ?>
					</ul>
				</div>
			</div>
			<div class="alignright rightpart">
				<h3><?php echo __('Deal Kampagnen von Spreadly'); ?></h3>
				<p><?php echo __('Sie haben eine gute Entscheidung getroffen, denn Sie zahlen nur für die tatsächlich erzielte Reichweite Ihrer Kampagne.<br/> Ihr Deal erscheint für den Teilnehmer als Angebot im Like-Popup von Spreadly.<br/> Sie erreichen so eine internetaffine Zielgruppe, die gern Inhalte über verschiedene Social Media Kanäle verbreitet.<br/> Gestalten Sie Ihr Angebot so reizvoll wie möglich, damit sich schnell der von Ihnen gewünschte Erfolg einstellt. In den Statistiken können Sie jederzeit die Resonanz Ihrer Kampagne prüfen.'); ?></p>
				<?php echo link_to(__('Bearbeiten der Kampagne'), 'deals/step_campaign?did='.$pDeal->getId(), array('class' => 'link')); ?>
			</div>
		</div>



		<div class="clearfix stepitem definieren">
			<div class="alignleft leftpart">
				<h3><?php echo __('Deal definieren')?></h3>
				<ul class="profiledetail-list clearfix">
					<li><span class="title"><?php echo __('Motivator'); ?>:</span><?php echo $pDeal->getMotivationTitle(); ?></li>
					<li><span class="title"><?php echo __('Motivationstext'); ?>:</span><?php echo $pDeal->getMotivationText(); ?></li>
					<li><span class="title"><?php echo __('Spread Werbung'); ?>:</span><?php echo $pDeal->getSpreadTitle(); ?></li>
					<li><span class="title"><?php echo __('Spread Teaser'); ?>:</span><?php echo $pDeal->getSpreadText(); ?></li>
					<li><span class="title"><?php echo __('Spread URL'); ?>:</span><?php echo $pDeal->getSpreadUrl(); ?></li>
					<li><span class="title"><?php echo __('Spread Bild'); ?>:</span><?php echo $pDeal->getSpreadImg(); ?></li>
					<li class="last"><span class="title"><?php echo __('Spread AGB'); ?>:</span><?php echo $pDeal->getSpreadTos(); ?></li>
				</ul>
			</div>
			<div class="alignright rightpart">
				<?php include_partial('deals/popup_share', array('pDeal' => $pDeal))?>
				<?php echo link_to(__('Bearbeiten des Deals'), 'deals/step_share?did='.$pDeal->getId(), array('class' => 'link')); ?>
			</div>
		</div>







		<div class="clearfix stepitem gutscheins">
			<div class="alignleft leftpart">
				<h3>Bearbeiten des Gutscheins</h3>
				<ul class="profiledetail-list clearfix">
					<li><span class="title">Name des Gutscheins:</span>Markovski</li>
					<li><span class="title">Gutscheintext:</span>Text</li>
					<li><span class="title">Gutscheinquelle:</span>url</li>
					<li class="last"><span class="title">Gutschein/Download URL:</span>https://plus.google.com/</li>
				</ul>
			</div>
			<div class="alignright rightpart">
				<span class="image"><img src="img/voucher-img.jpg" alt="" title=""></span>
				<a href="#" class="link" title="Bearbeiten des Deals">Bearbeiten des Deals</a>
			</div>
		</div>
		<div class="clearfix stepitem rechnungsadresse">
			<div class="alignleft leftpart">
				<h3>Rechnungsadresse</h3>
				<ul class="profiledetail-list clearfix">
					<li><span class="title">Zahlungsart:</span>Rechung</li>
					<li><span class="title">Unternehmen:</span>Markovski</li>
					<li><span class="title">Ansprechpartner:</span>Marks</li>
					<li><span class="title">Stra&szlig;e / Postfach:</span>Markach</li>
					<li><span class="title">PLZ:</span>Plz tebi</li>
					<li class="last"><span class="title">Ort:</span>Tro</li>
				</ul>
			</div>
			<div class="alignright rightpart">
				<h3>Rechnungsadresse</h3>
				<p>Bitte &uuml;berpr&uuml;ften Sie, ob die Rechnungsdaten richtig sind.</p>
				<a href="#" class="link" title="Bearbeiten der Rechnungsadresse">Bearbeiten der Rechnungsadresse</a>
			</div>
		</div>
		<div class="stepitem signagree">
			<p>Sind Sie sicher, dass alle Eingaben korrekt sind? Sie lassen sich nach dem Absenden nicht mehr &auml;ndern. Wenn ja, klicken Sie bitte auf Deal senden". Sie erhalten nach der Freigabe durch das Spreadly-Team eine Mail und Ihr Like Angebot wird umgehend in unserem Pool geschaltet.</p>
			<div class="agreecheck clearfix"><label class="checkbox-label"><input type="checkbox">Ich aktzeptiere die Allgemeinen Gesch&auml;ftsbedingungen von Spreadly.</label></div>
		</div>
		<span class="btnbarlist"><label class="pink-btn"><input type="button"  value="Next"></label></span>
	</div>
</div>
</form>
</section>