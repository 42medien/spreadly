<?php use_helper('Text'); ?>
<!DOCTYPE html>
<html>
  <head>
    <title>Spread.ly - first choice for social sharing</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="description" content="Spread.ly consists of sharing button widgets that enable users to share content into a wide range of social networks simultanously. Besides that, Spread.ly offers a sophisticated functionality to reward users for their likes." />
    <meta name="keywords" content="sharing,sharebutton,like,likebutton,deal,dealbutton,facebook,linkedin,twitter,buzz" />
    <link rel="stylesheet" type="text/css" href="/css/widget/popup.css" media="screen" />
    <link rel="stylesheet" type="text/css" href="/css/widget/Button.css" media="screen" />

    <!--[if lt IE 9]>
      <link rel="stylesheet" type="text/css" href="/css/popup-ie.css" />
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <script type="text/javascript">var _sf_startpt=(new Date()).getTime();</script>
    <script type="text/javascript" src="/js/100_main/include/widget-<?php echo sfConfig::get('app_release_name') ?>.js"></script>

		<script>
		function reload_services() {
		  OnLoadGrafic.hideGrafic();
			jQuery('#like-submit').empty();
		  var lAction = '/like/get_services';
		  var lData = {
		    	ei_kcuf : new Date().getTime(),
		  	};

		  jQuery.ajax({
				type : "GET",
				url : lAction,
				dataType : "json",
				data : lData,
		    success : function(pResponse) {
		    	jQuery('#like-submit').append(pResponse.services);
		    	if(!jQuery('#nav-username').length){
						jQuery('footer').empty();
						jQuery('footer').append(pResponse.footer);
			    }
		      OnLoadGrafic.hideGrafic();
		    }
		  });
		}


		</script>

    <link rel="shortcut icon" href="/favicon.ico" />

  </head>
  <body>
    <div class="popupblock">

      <!-- transparent-grauer Hintergrund mit Überschrift -->
      <div id="content-outer" role="main">
        <?php echo $sf_content; ?>

        <!-- popup footer -->

        <footer>
          <!-- Hauptnavigation -->
					<?php include_partial('global/footer'); ?>
        </footer>
      </div>
    </div>

		<img id="general-ajax-loader" style="display:none;" src="/img/global/ajax-loader-bar-circle.gif" />
	  <script  type="text/javascript">
	    jQuery(document).ready( function() {
	      <?php
	        if (has_slot('js_document_ready')) {
	          include_slot('js_document_ready');
	        }
	      ?>
	    });


      var _sf_async_config={uid:23222,domain:"spread.ly"};
      (function(){
        function loadChartbeat() {
          window._sf_endpt=(new Date()).getTime();
          var e = document.createElement('script');
          e.setAttribute('language', 'javascript');
          e.setAttribute('type', 'text/javascript');
          e.setAttribute('src',
             (("https:" == document.location.protocol) ? "https://a248.e.akamai.net/chartbeat.download.akamai.com/102508/" : "http://static.chartbeat.com/") +
             "js/chartbeat.js");
          document.body.appendChild(e);
        }
        var oldonload = window.onload;
        window.onload = (typeof window.onload != 'function') ?
           loadChartbeat : function() { oldonload(); loadChartbeat(); };
      })();
	  </script>
  </body>
</html>
