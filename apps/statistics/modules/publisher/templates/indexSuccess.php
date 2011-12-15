			<section class="content-publish">
			<section class="container_12 submenue">
				<div class="page-titlecontent">
					<h2><?php echo __('Herzlich Willkommen'); ?></h2>
					<p><?php echo __('Holen Sie sich jetzt den Spreadly Button für ihre Seite.Registrieren Sie ihre Webseite bei Spreadly und erhalten sie damit Analyse-Daten über Shares, Likes und Media Penetration ihrer User. Verdienen Sie nach der Registrierung über unser Adnetwork bares Geld, indem Sie an jedem geklickten Deal beteiligt werden.'); ?></p>
				</div>
				<section class="publisher-list">
					<ul class="clearfix">
						<li>
							<span class="icon"><img src="/img/statistics/get-btn-icon.png" alt="" title=""></span>
							<h3><?php echo __('Get Button'); ?></h3>
							<h4><?php echo __('Vorteil vielfacher Reichweite'); ?></h4>
							<p><?php echo __('Besucher teilen ihre Kommentare zu Inhalten und Produkten per Klick auf den Spreadly-Button in verschiedene Social Media-Netzwerke. Kontakte der Besucher können mit Kommentaren und Klicks reagieren. Werbende Empfehlungen haben ebenfalls die große Reichweite.'); ?></p>
							<span class="link"><a href="<?php echo url_for('@configurator'); ?>"><?php echo __('Generate your button code &raquo;'); ?></a></span>
						</li>
						<li>
							<span class="icon"><img src="/img/statistics/domain-icon.png" alt="" title=""></span>
							<h3><?php echo __('Domain registrieren'); ?></h3>
							<h4><?php echo __('Earn money and use other exclusive'); ?></h4>
							<p><?php echo __('Site operators receive analytic data to gain knowledge about the exact effect of their shared contents. They gain money because the advertisement appears in the Like-Popup window after sharing a content of the web site. Register your domain to get the analytics and earn money!'); ?></p>
							<span class="link"><a href="<?php echo url_for('@domain_profiles'); ?>"><?php echo __('Start the domain registration process &raquo;'); ?></a></span>
						</li>
						<li class="last">
							<span class="icon"><img src="/img/statistics/get-analytics.png" alt="" title=""></span>
							<h3><?php echo __('Social Media Analytics'); ?></h3>
							<h4><?php echo __('Vorteile für Seitenbetreiber'); ?></h4>
							<p><?php echo __('Mit Spreadly erfährst Du alles was in Sachen Empfehlungsmarketing wichtig ist. Wir zeigen Die wie, ob und dank wem Dein Empfehlungsmarketing funktioniert.'); ?></p>
							<span class="link"><a href="<?php echo url_for('@analytics_overview'); ?>"><?php echo __('Watch your detailled site analytics &raquo;'); ?></a></span>
						</li>
					</ul>
				</section>
				<?php include_partial('global/spreadly_references');?>
			</section>
		</section>