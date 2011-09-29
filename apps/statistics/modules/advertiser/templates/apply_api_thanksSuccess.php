<?php slot('content') ?>
<h2><?php echo __('Ihre Anfrage wurde versendet'); ?></h2>
<div><?php echo __('Wir werden sie unmittelbar unter ihrer angegebenen Email-Adresse %email% kontaktieren!', array('%email%' => $pUser->getEmailAddress())); ?></div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>