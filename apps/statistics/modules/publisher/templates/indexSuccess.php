<?php slot('content') ?>
<h2><?php echo __('Herzlich Willkommen im Publisher-Bereich'); ?></h2>
<div><?php echo __("Holen Sie sich jetzt den Spreadly Button für ihre Seite. <br/><br/>Registrieren Sie ihre Webseite bei Spreadly und erhalten sie damit Analyse-Daten über Shares, Likes und Media Penetration ihrer User.<br/><br/>Verdienen Sie nach der Registrierung über unser Adnetwork bares Geld, indem Sie an jedem geklickten Deal beteiligt werden."); ?></div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<div class="clearfix services_list">
	<div class="alignleft item">
		<div class="grboxtop"><span></span></div>
		<div class="grboxmid">
			<div class="grboxmid-content">
				<div class="graybox service_content advertiser_content">
					<h3 class="header"><a href="<?php echo url_for('@configurator')?>" class="bluetxt"><?php echo __("Get Button"); ?></a><span><?php echo __("Benefit from four times greater range"); ?></span></h3>
					<p><?php echo __("Users comment on contents and products and share their feedback with a single click on the Spreadly-button on different social networks. Their contacts can react by commenting. Every commercial recommendation also profits from the great reach."); ?></p>
					<p><?php echo link_to(__('Generate your button code'), '@configurator'); ?></p>
				</div>
			</div>
		</div>
		<div class="grboxbot"><span></span></div>
	</div>
	<div class="alignleft item">
		<div class="grboxtop"><span></span></div>
		<div class="grboxmid">
			<div class="grboxmid-content">
				<div class="graybox service_content advertiser_content">
					<h3 class="header"><a href="<?php echo url_for('domain_profiles/index')?>" class="bluetxt"><?php echo __("Register your domain"); ?></a><span><?php echo __("Earn money and use other exclusive benefits"); ?></span></h3>
					<p><?php echo __("Site operators receive analytic data to gain knowledge about the exact effect of their shared contents. They gain money because the advertisement appears in the Like-Popup window after sharing a content of the web site. Register your domain to get the analytics and earn money!"); ?></p>
					<p><?php echo link_to(__('Start the domain registration process'), 'domain_profiles/index'); ?></p>
				</div>
			</div>
		</div>
		<div class="grboxbot"><span></span></div>
	</div>
	<div class="alignright itemlast">
		<div class="grboxtop"><span></span></div>
		<div class="grboxmid">
			<div class="grboxmid-content">
				<div class="graybox service_content advertiser_content">
					<h3 class="header"><a href="<?php echo url_for('@analytics_overview')?>" class="bluetxt"><?php echo __("Get Analytics"); ?></a><span><?php echo __("Watch your spread analytics"); ?></span></h3>
					<p><?php echo __("Spreadly offers a new advertising format. Advertisers pay and book an exact range. The linking of commercial message and voucher as thanks for the recommendation makes the ad attractive to the user. They are well aware of the ad message because it appears right after the focused like."); ?></p>
					<p><?php echo link_to(__('Watch your detailled site analytics'), '@analytics_overview'); ?></p>
				</div>
			</div>
		</div>
		<div class="grboxbot"><span></span></div>
	</div>
</div>
