<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
  </head>
  <body class="bg_light">
    <div id="container" class="bd_round clearfix">
      <div id="content" class="clearfix">
        <div id="content_sub" class="left">
          <?php if($this->hasComponentSlot('sidebar_left_main')) { ?>
            <?php include_component_slot('sidebar_left_main'); ?>
          <?php } ?>
        </div>

        <div id="content_main" class="left">
          <?php echo $sf_content; ?>
        </div>

        <div id="content_supp" class="left">
          <?php if($this->hasComponentSlot('sidebar_right_top')) { ?>
            <?php include_component_slot('sidebar_right_top'); ?>
          <?php } ?>

          <?php if($this->hasComponentSlot('sidebar_right_main')) { ?>
            <?php include_component_slot('sidebar_right_main'); ?>
          <?php } ?>
        </div>

      </div>

      <?php //include_partial('global/footer'); ?>

    </div>

    <div id="footer" class="clearfix">

    </div>
  </body>
</html>