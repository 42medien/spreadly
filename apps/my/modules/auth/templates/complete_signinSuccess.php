<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript">
      function close_window_initiator() {
        window.opener.WidgetAddService.reloadServices();
        var t=setTimeout("close_window()", 30);
      }

      function close_window() {
        window.close();
      }
    </script>
  </head>

  <body onload="close_window_initiator()" style="margin: 50px 30px;">
    <p></p>
    <p><small><a href="javascript:close();"><?php echo __("window is closing automatically. if not, click here"); ?></a></small></p>
  </body>
</html>