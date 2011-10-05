<?php slot('content') ?>
<h2><?php echo __('Ihre Anfrage wurde versendet'); ?></h2>
<div><?php echo __('Wir werden sie unmittelbar unter ihrer angegebenen Email-Adresse %email% kontaktieren!', array('%email%' => $pUser->getEmailAddress())); ?></div>
<div><?php echo __('Die Dokumentation zur API finden Sie unter %apilink%.',array('%apilink%' => link_to('http://code.google.com/p/spreadly/wiki/Deal_API', 'http://code.google.com/p/spreadly/wiki/Deal_API'))); ?></div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>