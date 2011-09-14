<!DOCTYPE html>
<html>
  <head>
    <script type="text/javascript">
      function close_window() {
        window.opener.WidgetAddService.reloadServices();
        window.close();
      }
    </script>
  </head>

  <body onload="close_window()">
    <?php echo __("authentication is done. window is closing automatically"); ?>
  </body>
</html>