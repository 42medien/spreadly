			<section class="content-publish">
			<section class="container_12 submenue">
				<div class="page-titlecontent">
					<h2><?php echo __('Herzlich Willkommen'); ?></h2>
					<p><?php echo __('Schalten Sie Ihre Kampagne im Spreadly Ad-Network. Nach nur 5 einfachen Schritten erscheint Ihre Kampagne auf über 1.000 Seiten im Spreadly Ad-Network. Sie werden mit Ihrem speziellen Angebot das "kleine Dankeschön" für TOP-Empfehlungsgeber und Influencer. Entscheiden Sie selbst ob Ihnen eine feste Anzahl von LIKES wichtiger ist, oder Sie eine große Reichweite und Sichtbarkeit für Ihre Kampagne vorziehen.Das Spreadly Ad-Network macht den Einstieg in die Werbewelt zum Kinderspiel.Unser faires und transparentes Abrechnungsmodell wird auch Sie überzeugen.Legen Sie einfach los'); ?></p>
				</div>
				<section class="publisher-list">
					<ul class="clearfix">
						<li>
							<span class="icon"><img src="/img/statistics/get-btn-icon.png" alt="" title=""></span>
							<h3><?php echo __('Das Spreadly Ad-Network'); ?></h3>
							<h4><?php echo __('Vorteil vielfacher Reichweite'); ?></h4>
							<p><?php echo __('Besucher teilen ihre Kommentare zu Inhalten und Produkten per Klick auf den Spreadly-Button in verschiedene Social Media-Netzwerke. Kontakte der Besucher können mit Kommentaren und Klicks reagieren. Werbende Empfehlungen haben ebenfalls die große Reichweite.'); ?></p>
							<span class="link"><a href="<?php echo url_for('deals/campaign'); ?>"><?php echo __('Neue Kampagne starten &raquo;'); ?></a></span>
						</li>
						<li>
							<span class="icon"><img src="/img/statistics/domain-icon.png" alt="" title=""></span>
							<h3><?php echo __('Spreadly Deal API'); ?></h3>
							<h4><?php echo __('Vorteile für Seitenbetreiber'); ?></h4>
							<p><?php echo __('Wie bieten zahlreiche APIs für Deinen speziellen Fall. Ob der Import vieler Kampagnen oder das Auslösen bestimmter Aktionen bei jedem Klick, für alle Bedürfnisse haben die passende Lösung'); ?></p>
							<span class="link"><a href="<?php echo url_for('@dealapi'); ?>"><?php echo __('Start to use our API &raquo;'); ?></a></span>
						</li>
						<li class="last">
							<span class="icon"><img src="/img/statistics/get-analytics.png" alt="" title=""></span>
							<h3><?php echo __('Social Media Analytics'); ?></h3>
							<h4><?php echo __('Vorteile für Werbetreibende'); ?></h4>
							<p><?php echo __('Mit Spreadly erfährst Du alles was in Sachen Empfehlungsmarketing wichtig ist. Wir zeigen Die wie, ob und dank wem Dein Empfehlungsmarketing funktioniert.'); ?></p>
							<span class="link"><a href="<?php echo url_for('@deal_analytics_index'); ?>"><?php echo __('Watch your detailled deal analytics &raquo;'); ?></a></span>
						</li>
					</ul>
				</section>
				<?php include_partial('global/spreadly_references');?>
			</section>
		</section>