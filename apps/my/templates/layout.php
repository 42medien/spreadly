<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <?php include_title() ?>
    <link rel="shortcut icon" href="/favicon.ico" />
    <?php include_stylesheets() ?>

    <meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <!-- Le styles -->
    <style type="text/css">
      body {
        padding-top: 60px;
        padding-bottom: 40px;
      }
    </style>

    <script  type="text/javascript">
      /**
       * inline-add for the services the user want to share
       */
      var WidgetAddService = {
        reloadServices: function() {
          window.location = '/statistics/index';
        }
      };
    </script>

    <link href="css/bootstrap-responsive.min.css" rel="stylesheet" />

    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
  </head>
  <body>
    <div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="brand" href="/">my.spread.ly</a>
          <div class="nav-collapse">
            <ul class="nav">
              <li<?php if ($sf_context->getModuleName() == "landing") { ?> class="active"<?php } ?>><a href="/"><?php echo __("Home"); ?></a></li>
              <li<?php if ($sf_context->getModuleName() == "statistics") { ?> class="active"<?php } ?>><?php echo link_to(__("Statistics"), "statistics/index"); ?></li>
              <li<?php if ($sf_context->getModuleName() == "shares") { ?> class="active"<?php } ?>><?php echo link_to(__("Latest 'Likes'"), "shares/index"); ?></li>
            </ul>
            <form class="navbar-search pull-left" action="<?php echo url_for("shares/index"); ?>" method="GET">
              <input type="text" class="search-query" name="s" placeholder="<?php echo __("Search through your Shares"); ?>">
            </form>
          <?php if ($sf_user->getUser()) { ?><p class="navbar-text pull-right"><?php echo __("Logged in as:"); ?> <?php echo link_to($sf_user->getUser()->getFullname(), "@profile"); ?> | <?php echo link_to(" ", "auth/signout", array("title" => __("Signout"), "class" => "icon-signout")); ?></p><?php } ?>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>
    <div class="container">
      <?php echo $sf_content ?>

      <hr />
      <footer>
        <p>&copy; ekaabo GmbH 2012</p>
      </footer>
    </div>

    <?php include_javascripts() ?>

  </body>
</html>
