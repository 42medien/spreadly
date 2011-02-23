<div id="nav_supp" class="clearfix">
  <?php echo link_to(__('Imprint'), "http://www.yiid.com/imprint"); ?>
  <?php echo link_to(__('Terms of Services'), "http://www.yiid.com/tos"); ?>
  <?php echo link_to(__('Privacy Policy'), "http://www.yiid.com/privacy"); ?>

  <?php echo mail_to('info@spreadly.com'); ?>
</div>

<script type="text/javascript" charset="utf-8">
  var is_ssl = ("https:" == document.location.protocol);
  var asset_host = is_ssl ? "https://s3.amazonaws.com/getsatisfaction.com/" : "http://s3.amazonaws.com/getsatisfaction.com/";
  document.write(unescape("%3Cscript src='" + asset_host + "javascripts/feedback-v2.js' type='text/javascript'%3E%3C/script%3E"));
</script>

<script type="text/javascript" charset="utf-8">
  var feedback_widget_options = {};

  feedback_widget_options.display = "overlay";
  feedback_widget_options.company = "ekaabo";
  feedback_widget_options.placement = "left";
  feedback_widget_options.color = "#222";
  feedback_widget_options.style = "idea";

  var feedback_widget = new GSFN.feedback_widget(feedback_widget_options);
</script>