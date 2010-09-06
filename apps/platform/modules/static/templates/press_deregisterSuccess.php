<script language="javascript" type="text/javascript">


function checkFieldsOut ()
{
    var checkOK=true;

    if (document.getElementById('stdOut3').value.match(/^\s*$/)) checkOK=false;

    if (checkOK) document.getElementById('unsubscribe').submit();
    else window.alert("Bitte füllen Sie das E-Mail Feld aus.");
}



</script>


<h1><?php echo __('HEADLINE_PRESS_DEREGISTER')?></h1>
<p class="newsletter-register-description"><?php echo __('DESCRIPTION_PRESS_DEREGISTER')?></p>
<form name="unsubscribe" class="newsletter-form" id="unsubscribe" action="http://redirect2.mailingwork.de/delete_abo.php" method="post" enctype="multipart/form-data" target="_blank">
<table border="0" cellpadding="2" cellspacing="0">
   <tr>
        <td><?php echo __('NEWSLETTER_NAME').':'?></td>
        <td><input type="text" id="stdOut2" name="Name"   class="inputtext"</td>
    </tr>

    <tr>
        <td><?php echo __('NEWSLETTER_PRENAME').':'?></td>
        <td><input type="text" id="stdOut1" name=  class="inputtext"  class="inputtext" /></td>
    </tr>
    <tr>
        <td><?php echo __('NEWSLETTER_EMAIL').'*:'?></td>
        <td><input type="text" id="stdOut3" name="email"  class="inputtext" /></td>
    </tr>

    <tr>
        <td>&nbsp;</td>
        <td><input type="button" value="abmelden" onclick="checkFieldsOut()" class="button green small" /></td>
    </tr>
     
</table>
<input type="hidden" name="formtype" value="eMail" />
<input type="hidden" name="customerID" value="MTA2MA%3D%3D" />
<input type="hidden" name="Liste[1]" value="MTA2NjY%3D" />
</form>