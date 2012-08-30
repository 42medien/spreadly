<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript">
      try {
        window.opener.WidgetAddService.reloadServices();
        var t=setTimeout("close_window()", <?php echo $delay; ?>);
      } catch (err) {
        window.location = "<?php echo sfConfig::get("app_settings_my_url"); ?>/auth/complete_signin";
      }

      function close_window() {
        window.close();
      }
    </script>
  </head>

  <body onload="close_window_initiator()" style="margin: 50px 30px;">
    <p><?php
    if ($errorMsg) {
      echo "error: " . __($errorMsg);
    } else {
      echo __("authentication is done.");
    }
    ?></p>
    <p><small><a href="javascript:close();"><?php echo __("window is closing automatically. if not, click here"); ?></a></small></p>
  </body>
</html>