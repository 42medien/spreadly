<?php slot('content') ?>
<h2><?php echo __('Herzlich Willkommen'); ?></h2>
<div><?php echo __('Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur, weil er Schmerz ist, es sei denn, es kommt zu zufälligen Umständen, in denen Mühen und Schmerz ihm große Freude bereiten können. Um ein triviales Beispiel zu nehmen, wer von uns unterzieht sich je anstrengender körperlicher Betätigung, außer um Vorteile daraus zu ziehen? Aber wer hat irgend ein Recht, einen Menschen zu tadeln, der die Entscheidung trifft,<br/><br/>eine Freude zu genießen, die keine unangenehmen Folgen hat, oder einen, der Schmerz vermeidet, welcher keine daraus resultierende Freude nach sich zieht? Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur, weil er Schmerz ist, es sei denn, es kommt zu zufälligen Umständen, in denen Mühen und Schmerz ihm große Freude bereiten können. Um ein triviales Beispiel zu nehmen, wer von uns unterzieht sich je anstrengender körperlicher Betätigung, außer um Vorteile daraus zu ziehen? Aber wer hat irgend ein Recht, <br/><br/>einen Menschen zu tadeln, der die Entscheidung trifft, eine Freude zu genießen, die keine unangenehmen Folgen hat, oder einen, der Schmerz vermeidet, welcher keine daraus resultierende Freude nach sich zieht? Auch gibt es niemanden, der den Schmerz an sich liebt, sucht oder wünscht, nur,'); ?></div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
<div class="clearfix services_list">
	<div class="alignleft item">
		<div class="grboxtop"><span></span></div>
		<div class="grboxmid">
			<div class="grboxmid-content">
				<div class="graybox service_content advertiser_content">
					<h3 class="header"><a href="<?php echo url_for('@deals')?>" class="bluetxt"><?php echo __("Start campaign"); ?></a><span><?php echo __("Benefit from four times greater range"); ?></span></h3>
					<p><?php echo __("Users comment on contents and products and share their feedback with a single click on the Spreadly-button on different social networks. Their contacts can react by commenting. Every commercial recommendation also profits from the great reach."); ?></p>
					<p><?php echo link_to(__('Create a deal and start campaign'), '@deals'); ?></p>
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
					<h3 class="header"><a href="<?php echo url_for('@dealapi')?>" class="bluetxt"><?php echo __("Use the deal API"); ?></a><span><?php echo __("Benefit for site operators"); ?></span></h3>
					<p><?php echo __("Site operators receive analytic data to gain knowledge about the exact effect of their shared contents. They gain money because the advertisement appears in the Like-Popup window after sharing a content of the web site. The ad is always associated with vouchers for recommendations. Users get the vouchers directly."); ?></p>
					<p><?php echo link_to(__('Start to use our API'), '@dealapi'); ?></p>
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
					<h3 class="header"><a href="<?php echo url_for('@deal_analytics_index')?>" class="bluetxt"><?php echo __("Get Analytics"); ?></a><span><?php echo __("Benefits for advertisers"); ?></span></h3>
					<p><?php echo __("Spreadly offers a new advertising format. Advertisers pay and book an exact range. The linking of commercial message and voucher as thanks for the recommendation makes the ad attractive to the user. They are well aware of the ad message because it appears right after the focused like."); ?></p>
					<p><?php echo link_to(__('Watch your detailled campaign analytics'), '@deal_analytics_index'); ?></p>
				</div>
			</div>
		</div>
		<div class="grboxbot"><span></span></div>
	</div>
</div>
