<?php use_helper('Date'); ?>
E-Mail<?php echo "\t"?>Username<?php echo "\t"?>Vorname<?php echo "\t"?>Nachname<?php echo "\t"?>Registrierung<?php echo "\t"?>Letzter Login<?php echo "\t"?>Domain<?php echo "\t"?>Verifiziert
<?php foreach($pDomainProfiles as $dp): ?>
<?php echo $dp->getSfGuardUser()->getEmailAddress() ?><?php echo "\t"?><?php echo $dp->getSfGuardUser()->getUsername() ?><?php echo "\t"?><?php echo $dp->getSfGuardUser()->getProfile()->getFirstname() ?><?php echo "\t"?><?php echo $dp->getSfGuardUser()->getProfile()->getLastname() ?><?php echo "\t"?><?php echo format_date($dp->getSfGuardUser()->getCreatedAt(), "d.M.y") ?><?php echo "\t"?><?php echo format_date($dp->getSfGuardUser()->getLastLogin(), "d.M.y") ?><?php echo "\t"?><?php echo $dp->getDomain() ?><?php echo "\t"?><?php echo $dp->getState() ?>

<?php endforeach; ?>
<?php foreach($pOtherUsers as $u): ?>
<?php echo $u->getEmailAddress() ?><?php echo "\t"?><?php echo $u->getUsername() ?><?php echo "\t"?><?php echo $u->getProfile()->getFirstname() ?><?php echo "\t"?><?php echo $u->getProfile()->getLastname() ?><?php echo "\t"?><?php echo format_date($u->getCreatedAt(), "d.M.y") ?><?php echo "\t"?><?php echo format_date($u->getLastLogin(), "d.M.y") ?><?php echo "\t"?><?php echo "\t"?>

<?php endforeach; ?>