<?php use_helper('YiidUrl'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" dir="ltr">

<head profile="http://purl.org/uF/2008/03/">
  <?php include_http_metas() ?>
  <?php include_metas() ?>

  <title>YIID.cc - the url shortener</title>
  <link rel="shortcut icon" href="/favicon.ico" />
  <link rel="commands" title="yiid this" href="<?php echo sfConfig::get('app_settings_url'); ?>/js/browser-plugins/ubiquity/shorturl.js" />

  <link href='http://fonts.googleapis.com/css?family=Yanone+Kaffeesatz&subset=latin' rel='stylesheet' type='text/css'>

  <style type="text/css">
    body {
      font-family: 'Yanone Kaffeesatz', arial, serif;
    }

    #wrapper {
      margin: 0 auto;
      width: 500px;
    }

    h1, h1 a {
      color: #333;
      font-size: 50px;
    }

    .url-boxerle {
      border: 1px solid #ccc;
      padding: 20px;
      background-color: #eee;
    }

    table {
      width: 400px;
      margin: 5px auto;
    }

    table th {
      border-bottom: 1px solid #333;
      margin: 5px;
      text-align: left;
    }
  </style>
</head>

<body id="top" class="yiidcc module-<?php echo $sf_context->getModuleName() ?> action-<?php echo $sf_context->getActionName() ?>">

  <div id="wrapper">
    <h1>
      <?php echo link_to_frontend('YIID.cc', 'index/index', array('title' => 'YIID - Your Internet ID')); ?>
		</h1>

    <?php echo $sf_content ?>

    <hr />
    <p><a href="http://www.yiid.com/imprint">&raquo; Impressum</a> <a href="http://www.yiid.com/tos">&raquo; TOS</a> <a href="http://www.yiid.com/privacy">&raquo; Privacy Policy</a></p>
  </div>

  <?php if (sfConfig::get('app_settings_dev') == 0) { ?>
  <script type="text/javascript">
    var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
    document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
  </script>
  <script type="text/javascript">
    try {
      var pageTracker = _gat._getTracker("UA-105406-37");
      pageTracker._trackPageview();
    } catch(err) {}
  </script>
  <?php } ?>
</body>
</html>