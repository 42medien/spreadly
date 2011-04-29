<?php use_helper('Date'); ?>
E-Mail,Username,Vorname,Nachname,Registrierung,Letzter Login,Domain,Verifiziert
<?php foreach($pDomainProfiles as $dp): ?>
<?php echo $dp->getSfGuardUser()->getEmailAddress() ?>,<?php echo $dp->getSfGuardUser()->getUsername() ?>,<?php echo $dp->getSfGuardUser()->getProfile()->getFirstname() ?>,<?php echo $dp->getSfGuardUser()->getProfile()->getLastname() ?>,<?php echo format_date($dp->getSfGuardUser()->getCreatedAt(), "d.M.y") ?>,<?php echo format_date($dp->getSfGuardUser()->getLastLogin(), "d.M.y") ?>,<?php echo $dp->getDomain() ?>,<?php echo $dp->getState() ?>

<?php endforeach; ?>
<?php foreach($pOtherUsers as $u): ?>
<?php echo $u->getEmailAddress() ?>,<?php echo $u->getUsername() ?>,<?php echo $u->getProfile()->getFirstname() ?>,<?php echo $u->getProfile()->getLastname() ?>,<?php echo format_date($u->getCreatedAt(), "d.M.y") ?>,<?php echo format_date($u->getLastLogin(), "d.M.y") ?>,,

<?php endforeach; ?>