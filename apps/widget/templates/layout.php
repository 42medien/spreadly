<?php use_helper('YiidUrl') ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <?php include_title() ?>
    <?php include_http_metas() ?>
    <?php include_metas() ?>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

		<link rel="stylesheet" type="text/css" href="/css/styles.css" media="screen" />
		<link rel="stylesheet" type="text/css" href="/css/print.css" media="print" />
		<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="/css/ie.css" />
		<![endif]-->
		<!--[if IE 6]>
		<script src="/js/DD_belatedPNG.js"> </script>
		<script>
		  DD_belatedPNG.fix('*');
		</script>
		<![endif]-->
    <script type="text/javascript" src="/js/100_main/include/widget-<?php echo sfConfig::get('app_release_name') ?>.js"></script>
    <link rel="shortcut icon" href="/img/global/favicon_16x16.ico" />
  </head>
  <body class="nobg">
		<div class="popupblock">
			<div class="sharepic">
				<a href="#">
					<img src="/img/share-pic.png" width="118" height="135" alt="Share" title="Share" />
				</a>
			</div>
    	<div class="pop-header clearfix">
    		<a href="#" class="alignleft spreadlogo">
    			<img src="/img/spread-logo.png" width="211" height="88" alt="Spread.ly" title="Spread.ly" />
    		</a>
    		<img src="/img/like-slogan.png" class="alignleft slogantext" width="166" height="53" alt="Spread.ly" title="Spread.ly" />
  		</div>

      <!--Pop Navigation start -->
      <?php if ($sf_user->isAuthenticated() ) {?>
      <div class="popnav">
      	<div class="popnavbg clearfix">
        	<div class="profile-info alignright">
          	<img src="/img/marco.jpg" width="25" height="26" alt="<?php echo $sf_user->getUser()->getUsername(); ?>" title="<?php echo $sf_user->getUser()->getUsername(); ?>" class="mic-pic" />Hi <?php echo $sf_user->getUser()->getUsername(); ?>,<span class="like">134</span><span class="dislike">8</span> | <?php echo link_to(__('Logout'), '/static/signout');?>
          </div>
          <ul class="popnavigation">
          	<li <?php if($sf_context->getModuleName()=='profile') { echo 'class="active"';} ?>><?php echo link_to(__('Profile'), '@popup_profile'); ?> <span></span></li>
            <li <?php if($sf_context->getModuleName()=='likes') { echo 'class="active"';} ?>><?php echo link_to(__('Likes'), 'settings/index'); ?><span></span></li>
            <li <?php if($sf_context->getModuleName()=='settings') { echo 'class="active"';} ?>><?php echo link_to(__('Settings'), '@popup_settings'); ?> <span></span></li>
            <li class="last <?php if($sf_context->getModuleName()=='deals') { echo 'active';} ?>"><?php echo link_to(__('Deals'), '@popup_deals'); ?> <span></span></li>
          </ul>
        </div>
      </div>
      <?php } ?>
      <!-- Pop Navigation end -->
      <div>
      	<div class="grboxtop">
      		<span></span>
      	</div>
        <div class="grboxmid">
        	<div class="grboxmid-content">
						<!-- start content -->
	          <?php echo $sf_content; ?>
                <!-- footer -->
                <div class="poweredrow">
                	<a href="#" title="Impressum">Impressum</a> | Powered by <img src="/img/spread-logosmall.jpg" width="16" height="16" alt="Spread" title="Spread" /></div>
                </div>
              </div>
            </div>
          <div class="grboxbot"><span></span></div>
        </div>
    	</div>
    <!--popup block end -->

	  <script  type="text/javascript">
	    jQuery(document).ready( function() {
	      jQuery("input[type='radio'],input[type='checkbox']").custCheckBox();
	      <?php
	        if (has_slot('js_document_ready')) {
	          include_slot('js_document_ready');
	        }
	      ?>
	    });
	  </script>
  </body>
</html>
