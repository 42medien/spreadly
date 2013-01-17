<?php use_helper("YiidNumber"); ?>

<div class="page-titlecontent">
	<h2><?php echo __('Willkommen im Spreadly Ad-Network'); ?></h2>
	<p><?php echo __('Schalten Sie noch heute Ihre Kampagne live und werden Sie Teil eines innovativen Webeformats im Social-Media-Zeitalter'); ?></p>
</div>

<section class="publisher-list">
	<ul class="clearfix">
		<li>
			<span class="icon"><i class="icon-bar-chart"></i></span>
			<h3><?php echo __('Der Button'); ?></h3>
			<p><?php echo __('Sie kommen gerade von der Seite %domain<br />
Im letzten Monat wurden Werbemittel hier %counter Mal angezeigt. 
Schon in wenigen Minuten können Sie hier werben.', array("%domain" => link_to($domain, $domain, array("class" => "alternative", "target" => "_blank")), "%counter" => "<span class='alternative'>".point_format($counter)."</span>")); ?></p>
			<span class="link"><a href="<?php echo $domain; ?>" target="_blank"><?php echo __('%domain besuchen &raquo;', array("%domain" => $domain)); ?></a></span>
		</li>
		<li>
			<span class="icon"><i class="icon-money"></i></span>
			<h3><?php echo __('Werbeformat'); ?></h3>
			<p><?php echo __('Bei der Wahl des Werbeformats richten wir uns ganz nach Ihnen. Ob Text, Video oder sonstige Formate, alle finden im Spreadly Ad-Network ihren Platz.<br />
Kontaktieren Sie uns noch heute, damit wir Ihnen ein passendes Angebot machen können.'); ?></p>
		</li>
		<li class="last">
			<span class="icon"><i class="icon-phone"></i></span>
			<h3><?php echo __('Ansprechpartner'); ?></h3>
			<p><strong>Marco Ripanti</strong><br /><br />E-Mail: <a href="mailto:kampagnen@spreadly.com">kampagnen@spreadly.com</a><br />Tel.: <a href="tel:+496201845200">06201 / 845 200</a></p>
			<span class="link"><a href="mailto:kampagnen@spreadly.com"><?php echo __('E-Mail schreiben &raquo;'); ?></a></span>
		</li>
	</ul>
</section>
