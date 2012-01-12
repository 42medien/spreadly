				<div class="page-titlecontent">
					<h2><?php echo __('Herzlich Willkommen'); ?></h2>
					<p><?php echo __('Schalten Sie Ihre Kampagne im Spreadly Ad-Network. Nach nur 5 einfachen Schritten erscheint Ihre Kampagne auf über 1.000 Seiten im Spreadly Ad-Network. Sie werden mit Ihrem speziellen Angebot das "kleine Dankeschön" für TOP-Empfehlungsgeber und Influencer. Entscheiden Sie selbst ob Ihnen eine feste Anzahl von LIKES wichtiger ist, oder Sie eine große Reichweite und Sichtbarkeit für Ihre Kampagne vorziehen.Das Spreadly Ad-Network macht den Einstieg in die Werbewelt zum Kinderspiel.Unser faires und transparentes Abrechnungsmodell wird auch Sie überzeugen.Legen Sie einfach los'); ?></p>
				</div>
				<section class="publisher-list">
					<ul class="clearfix">
						<li>
							<span class="icon"><img src="/img/statistics/get-btn-icon.png" alt="" title=""></span>
							<h3><?php echo __('Das Spreadly Ad-Network'); ?></h3>
							<h4><?php echo __('Ein Klick große Reichweite'); ?></h4>
							<p><?php echo __('Ihre Kampagne erreicht mit einem Klick Kontakte in den Netzwerken Facebook, Twitter, LinkedIn und Google+ Nach dem Empfehlen eines Inhalts erscheint Ihre Kampagne als "Dankeschön" und wird viral verbreitet.'); ?></p>
							<span class="link"><a href="<?php echo url_for('deals/campaign'); ?>"><?php echo __('Neue Kampagne starten &raquo;'); ?></a></span>
						</li>
						<li>
							<span class="icon"><img src="/img/statistics/get-analytics.png" alt="" title=""></span>
							<h3><?php echo __('Kampagnen-Modelle'); ?></h3>
							<h4><?php echo __('Schluss mit wirkungslosen TKP-Kampagnen'); ?></h4>
							<p><?php echo __('Profitieren Sie von den transparenten und fairen Kampagnenmodellen. Buchen Sie Reichweiten- oder Sharepakete. In Echtzeit können Sie den Erfolg und die Verbreitung Ihrer Kampagne im Spreadly-Backend verfolgen.'); ?></p>
							<span class="link"><a href="<?php echo url_for('@deal_analytics_index'); ?>"><?php echo __('Zu den Statistiken &raquo;'); ?></a></span>
						</li>
						<li class="last">
							<span class="icon"><img src="/img/statistics/domain-icon.png" alt="" title=""></span>
							<h3><?php echo __('Spreadly Deal API'); ?></h3>
							<h4><?php echo __('Selbstbuchungstool oder automatisierter Prozess'); ?></h4>
							<p><?php echo __('Wenn Sie nicht nur vereinzelte Kampagnen schalten möchten, sondern dauerhaft im Spreadly Ad-Network vertreten sein wollen, können Sie unsere DealAPI mit Ihren Kampagnen befüllen. Nehmen Sie hierzu einfach Kontakt mit uns auf.'); ?></p>
							<span class="link"><a href="<?php echo url_for('@dealapi'); ?>"><?php echo __('Für unsere API registrieren &raquo;'); ?></a></span>
						</li>
					</ul>
				</section>
				<?php include_partial('global/spreadly_references');?>
