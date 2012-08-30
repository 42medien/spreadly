<?php use_helper('I18N', 'Url') ?>
Hallo <?php echo $fullname ?>,

Ihr <?php echo $sf_request->getHost() ?> - Benutzername/ user name:  <?php echo $username ?>,

Sie benötigen ein neues Passwort? Klicken Sie folgenden Link und geben Sie das gewünschte, neue Passwort ein (Wenn Sie nicht klicken, bleibt Ihr altes Passwort erhalten.):

<?php echo url_for("sfApply/confirm?validate=$validate", true) ?>

If you have lost your password or wish to reset it, click on the link above.You will then be prompted for the new password you wish to use. (Your password will NOT be changed unless you click on the link above and complete the form.)


Mit freundlichen Grüßen und Regards
Spreadly-Team

info@spreadly.com
ekaabo GmbH
Grundelbachstr. 84
D-69469 Weinheim
tel: +49 6201 845200
fax: +49 6201 84520-29
www.ekaabo.de
Amtsgericht Mannheim / HRB 701542
Geschäftsführer: Marco Ripanti
Get your button & Spread your likes –www.Spreadly.com
Weblog – Blog.spreadly.com
