<script language="javascript" type="text/javascript">
<!--
var compulsoryFieldsIn=new Array();
compulsoryFieldsIn[0]="stdIn3";


function checkFieldsIn ()
{
    var checkOK=true;
    for (var i=0; i<compulsoryFieldsIn.length; i++)
    {
        var cfObj=document.getElementById(compulsoryFieldsIn[i]);

        if (cfObj!=null)
        {
            if (cfObj.type.toLowerCase()=="text")
            {
                if (cfObj.value.match(/^\s*$/)) checkOK=false;
            }
            else if (cfObj.type.toLowerCase()=="radio" || cfObj.type.toLowerCase()=="checkbox")
            {
        var tmpObj=document.getElementsByName(cfObj.name);
                var tmpCheck=false;
                for (var j=0; j<tmpObj.length; j++)
                {
                    if (tmpObj[j].checked==true)
                    {
                        tmpCheck=true;
                        break;
                    }
                }
                checkOK=tmpCheck;
            }
            else if (cfObj.type.toLowerCase().indexOf("select")>=0)
            {
                if (compulsoryFieldsIn[i]=="stdIn12" && cfObj.selectedIndex==0) checkOK=false;
            }
        }
        if (!checkOK) break;
    }

    if (checkOK) document.getElementById('subscribe').submit();
    else window.alert("Bitte füllen Sie alle mit einem * markierten Felder aus.");
}

//-->
</script>

     <h1><?php echo __('HEADLINE_NEWSLETTER_REGISTER')?></h1>
     <p class="newsletter-register-description"><?php echo __('DESCRIPTION_NEWSLETTER_REGISTER')?></p>
      <form name="subscribe" class="newsletter-form" id="subscribe" action="http://redirect2.mailingwork.de/addabo.php" method="post" enctype="multipart/form-data" target="_blank">
            <table border="0" cellpadding="2" cellspacing="0">
               <tr>
                 <td><?php echo __('NEWSLETTER_TITLE').':'?></td>
                 <td>
                  <?php $title = array(__('TITLE_MAN'),__('TITLE_WOMAN'),__('TITLE_FAMILY'),__('TITLE_COMPANY')); ?>
                  <?php  echo select_tag(__('NEWSLETTER_TITLE'), options_for_select($title ), array('id' => 'stdIn0')); ?>
                 </td>
                </tr>
                <tr>
                  <td><?php echo __('NEWSLETTER_NAME').':'?></td>
                  <td><input type="text" id="stdIn1" name="Nachname" value=""  class="inputtext" /></td>
                </tr>
                <tr>
                  <td><?php echo __('NEWSLETTER_PRENAME').':'?></td>
                  <td><input type="text" id="stdIn2" name="Vorname" value=""  class="inputtext"/></td>
                </tr>
                <tr>
                  <td><?php echo __('NEWSLETTER_EMAIL').'*:'?></td>
                  <td><input type="text" id="stdIn3" name="eMail" value=""  class="inputtext" /></td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td><input type="button" value="Newsletter anmelden" onclick="checkFieldsIn()" class="button green small" /></td>
                </tr>
            </table>
           <input type="hidden" name="formtype" value="eMail" />
<input type="hidden" name="customerID" value="MTA2MA%3D%3D" />
<input type="hidden" name="Liste[1]" value="MTEwNzA%3D" />
<input type="hidden" name="forceCharset" value="utf-8" />
