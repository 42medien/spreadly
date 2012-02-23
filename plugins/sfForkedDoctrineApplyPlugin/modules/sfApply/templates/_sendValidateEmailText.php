<?php use_helper('I18N', 'Url') ?>
Hallo <?php echo $fullname ?>,

Sie möchten Ihre eMail-Adresse auf <?php echo $sf_request->getHost() ?> von <?php echo $oldmail ?> in <?php echo $newmail ?> ändern.
Um diese Änderung zu bestätigen, klicken Sie bitte den folgenden Link:

<?php echo url_for("sfApply/confirm?validate=$validate", true) ?>



You like to change your email address on <?php echo $sf_request->getHost() ?> from <?php echo $oldmail ?> to <?php echo $newmail ?>.
To continue with your change, click on the link above. Your email will then be changed permanently.

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
