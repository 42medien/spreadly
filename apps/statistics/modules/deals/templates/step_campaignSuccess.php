<?php
//prefill for edit step_campaing
	if($pForm['billing_type']->getValue() == 'media_penetration'){
		$pForm->setDefault('target_quantity_mp', $pForm['target_quantity']->getValue());
	}
?>


<form action="<?php echo url_for('deals/step_campaign?did='.$pDealId); ?>" class="clearfix" name="create_deal_form" id="deal_form" method="POST">
				<?php echo $pForm['billing_type']->render(); ?>
				<h2><?php echo __('Get your button now!'); ?></h2>
				<section class="buttontabsection clearfix">
					<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>
					<div class="alignright tabcontainer">
						<div id="tab1" class="tabcontent">
							<div class="stepitem kampagnecontent clearfix" >
								<div class="alignleft leftpart first">
									<h3 class="toptitle"><?php echo __('Schritt 1: Kampagne anlegen'); ?></h3>
									<div class="contentbox">
										<p class="description"><?php echo __('Geben Sie Ihrer Kampagne einen Namen, damit Sie sie von eventuellen weiteren unterscheiden können. Dieser Name erscheint nicht öffentlich.'); ?></p>
										<?php echo $pForm['name']->renderError(); ?>
										<label class="btnform-input">
											<?php echo $pForm['name']->render(array('class' => 'name', 'placeholder' => __('Name'))); ?>
										</label>
										<ul class="kampagne-checklist clearfix">
											<li id="select-deal-type">
												<div class="alignleft title">
													<h4><?php echo __('Art des Deals'); ?></h4>
													<p><?php echo __('Wo soll ihr Deal überall <br>angezeigt werden?'); ?></p>
												</div>
												<?php echo $pForm['type']->render(); ?>
												<span><?php echo $pForm['type']->renderError(); ?></span>
											</li>
								    <!-- select-domain-profile -->
								    <li id="select-domain-profile-id" <?php echo ($pForm['type']->getValue() != 'publisher')? 'style="display:none;"':""; ?>>
								    	<div class="title wide-title clearfix">
								      	<h4><?php echo $pForm['domain_profile_id']->renderLabel(); ?></h4>
								      	<p class="description"><?php echo __('Auf welcher Domain soll der Deal laufen?'); ?></p>
								      	<?php echo $pForm['domain_profile_id']->renderError(); ?>
								      </div>
								      <?php if(count($pDomainProfiles) > 0) { ?>
								      	<?php echo $pForm['domain_profile_id']->render(); ?>
									    <?php } else { ?>
									    		<span><?php echo __('Um einen Deal speziell auf einer ihrer Webseiten schalten zu können müssen sie zunächst die gewünschte Domain bei Spreadly registrieren.'); ?>
									    		<?php echo link_to(__('Zur Domain-Registrierung'), 'domain_profiles/index'); ?></span>
									    <?php } ?>
								    </li>

										<!-- select-tags
								    <li id="select-tags" <?php echo ($pForm['type']->getValue() != 'tags')? 'style="display:none;"':""; ?>>

								    	<div class="alignleft title wide-title">
								      	<h4><?php //echo __('Sichtbarkeit');?></h4>
								      	<p><?php //echo __('Soll Ihr Deal nur für User oder nur auf Webseiten mit einem bestimmter Kategorie angezeigt werden?'); ?></p>
								      	<span><?php //echo $pForm['tag_model']->renderError(); ?></span>
								      </div>
								      	<?php //echo $pForm['tag_model']->render()?>

								    	<div class="alignleft title wide-title">
								      	<h4><?php //echo $pForm['tags']->renderLabel(); ?></h4>
								      	<p class="description"><?php //echo __('Geben Sie hier, mit Komma getrennt, die Kategorien, wie zum Beispiel "Sport", an, bei denen ihre Deals angezeigt werden sollen.'); ?></p>
								      	<span><?php //echo $pForm['tags']->renderError(); ?></span>
								      </div>

								      <label class="btnform-input">
								      	<?php //echo $pForm['tags']->render(array('class' => 'name', 'placeholder' => __('Tags'))); ?>
								      </label>
								      <div class="alignleft title wide-title" id="tag-choice-container">
								      	<div id="tag-choice-stats-container">
													<h4><?php //echo __('Mögliche Erreichbarkeit'); ?></h4>
													<div>
														<span class="tag-choice-label">User:</span>
														<span class="icon-thumbs-up icon-medium"></span><span id="count-likes">254</span>
														<span class="icon-chevron-right icon-normal"></span>
														<span class="icon-share icon-medium"></span><span id="count-shares">36 500</span>
														<span class="icon-chevron-right icon-normal"></span> <span id="count-mp">156 559</span> Media Penetration
													</div>
													<div>
														<span class="tag-choice-label">Services:</span>
														<span class="icon-facebook-sign icon-medium"></span><span id="count-fb">30 485</span>
														<span class="icon-plus icon-normal"></span>
														<span class="icon-twitter-sign icon-medium"></span><span id="count-tw">32 586</span>
														<span class="icon-plus icon-normal"></span>
														<span class="icon-linkedin-sign icon-medium"></span><span id="count-ln">10 825</span>
														<span class="icon-plus icon-normal"></span>
														<span class="icon-question-sign icon-medium"></span><span id="count-other">20 312</span>
													</div>
													<div>
														<span class="tag-choice-label">Webseiten:</span>
														<span class="icon-home icon-medium"></span><span id="count-allsites">10 093</span>
													</div>
								      	</div>
								      </div>
								    </li>
										-->

											<li class="select-target-quantity" id="select-target-quantity">
												<div class="alignleft title">
													<h4><?php echo __('Streuung nach Likes'); ?></h4>
													<p><?php echo __('Sie buchen für Ihre Kampagne eine bestimmte Anzahl von Likes. Bitte wählen Sie.'); ?></p>
												</div>
												<?php echo $pForm['target_quantity']->render(array('class'=> "target_quantity_like")); ?>
												<span><?php echo $pForm['target_quantity']->renderError(); ?></span>
											</li>
											<li class="last select-target-quantity" id="select-target-quantity-mp">
												<div class="alignleft title">
													<h4><?php echo __('Streuung nach <br>Reichweite'); ?></h4>
													<p><?php echo __('Sie möchten, dass Ihre Kampagne von möglichst vielen Leuten gesehen wird.'); ?></p>
												</div>
												<?php echo $pForm['target_quantity_mp']->render(array('class'=> "target_quantity_mp")); ?>
												<span><?php echo $pForm['target_quantity_mp']->renderError(); ?></span>
											</li>
										</ul>
									</div>
								</div>
								<div class="alignright rightpart">
									<h3>Deal Kampagnen von Spreadly</h3>
									<p>Sie haben eine gute Entscheidung getroffen, denn Sie zahlen nur f&uuml;r die tats&auml;chlich erzielte Reichweite Ihrer Kampagne. Ihr Deal erscheint f&uuml;r den Teilnehmer als Angebot im Like-Popup von Spreadly. Sie erreichen so eine internetaffine Zielgruppe, die gern Inhalte &uuml;ber verschiedene Social Media Kan&auml;le verbreitet.<br>
	Gestalten Sie Ihr Angebot so reizvoll wie m&ouml;glich, damit sich schnell der von Ihnen gew&uuml;nschte Erfolg einstellt. In den Statistiken k&ouml;nnen Sie jederzeit die Resonanz Ihrer Kampagne pr&uuml;fen.</p>
								</div>
							</div>
							<span class="btnbarlist"><label class="pink-btn"><input type="submit"  id="create_deal_button" value="<?php echo __('Weiter'); ?>"></label></span>
						</div>
					</div>
		</section>
</form>
