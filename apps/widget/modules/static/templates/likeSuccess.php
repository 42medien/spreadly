<?php use_helper('Text'); ?>

<div class="clearfix">
  <div id="twocol_wide_left" class="content_main_border rounded_corners light_background left">
  <?php if($pIsUrlValid) { ?>
    <div id="so_right_view" class="clearfix">
      <div>
        <h3 class="small_margin" title="<?php echo $pTitle; ?>"><?php echo truncate_text($pTitle, 30, '...'); ?></h3>
        <p title="<?php echo $pUrl; ?>"><?php echo link_to(UrlUtils::getShortUrl($pUrl), $pUrl, array('class' => 'url')); ?></p>
      </div>
      <div id="so_detail_desc" class="clearfix">
        <img alt="<?php echo $pUrl; ?>" width="100px" height="80px" src="<?php if(!$pImageUrl){ ?>http://communipedia.v2.websnapr.com/?url=<?php echo $pUrl; ?>&sh=80&sw=100<?php } else { echo $pImageUrl; } ?>" class="left">
        <span class="normal_text"><?php echo truncate_text($pDescription, 400, '...'); ?></span>
      </div>
    </div>

      <?php if ($pIsUsed == 1) { ?>
        <div class="rounded_corners content_main_border popup_button_used distance_right already_shared" id="static-liked">
          <span class="sharing_button likeit_button">&nbsp;</span>
          <?php echo __('done_'.$pType); ?>
        </div>
      <?php } elseif ($pIsUsed == -1) {?>
        <div class="rounded_corners content_main_border popup_button_used distance_right already_shared" id="static-disliked">
          <span class="sharing_button dislikeit_button">&nbsp;</span>
          <?php echo __('disdone_'.$pType); ?>
        </div>
	    <?php } else { ?>
		    <form action="" name="static-like-form" id="static-like-form" method="post">
		      <h3 class="small_margin"><?php echo __('YOUR_NETWORKS', null, 'widget'); ?></h3>
		      <input type="hidden" name="type" value="<?php echo $pType; ?>" />
		      <input type="hidden" name="url" value="<?php echo $pUrl; ?>" />
		      <input type="hidden" name="title" value="<?php echo $pTitle; ?>" />
		      <input type="hidden" name="description" value="<?php echo $pDescription; ?>" />
		      <?php if($pImageUrl){ ?>
		        <input type="hidden" name="photo" value="<?php echo $pImageUrl; ?>" />
		      <?php } ?>
		      <ul class="normal_list clearfix" id="services_chosen">
		      <?php foreach ($pIdentities as $lIdentity) { ?>
		        <li id="check_<?php echo $lIdentity->getCommunity()->getCommunity(); ?>">
		          <input type="checkbox" id="like-serv-<?php echo $lIdentity->getId(); ?>"
		            name="like-serv-<?php echo $lIdentity->getId(); ?>" <?php echo $lIdentity->getSocialPublishingEnabled()?"checked=checked":''; ?>
		            value="<?php echo $lIdentity->getId(); ?>" class="serv-check" />
		          <label for="<?php echo $lIdentity->getCommunity()->getCommunity(); ?>_check" title="<?php echo $lIdentity->getProfileUri(); ?>">
		            <?php echo truncate_text($lIdentity->getProfileUri(), 25, '...'); ?>
		          </label>
		        </li>
		      <?php } ?>
		      </ul>
		      <div class="rounded_corners content_main_border popup_button distance_right" id="static-like-button">
            <span class="sharing_button likeit_button">&nbsp;</span>
            <?php echo __($pType); ?>
          </div>
          <?php //if($pFull) {?>
	          <div class="rounded_corners content_main_border popup_button" id="static-dislike-button">
	            <span class="sharing_button dislikeit_button" id="static-dislike-button">&nbsp;</span>
	          </div>
          <?php //} ?>
        </form>
        <div class="rounded_corners content_main_border popup_button_used distance_right already_shared" id="static-liked" style="display: none;">
          <span class="sharing_button likeit_button">&nbsp;</span>
          <?php echo __('done_'.$pType); ?>
        </div>
        <div class="rounded_corners content_main_border popup_button_used distance_right already_shared" id="static-disliked" style="display: none;">
          <span class="sharing_button dislikeit_button">&nbsp;</span>
          <?php echo __('disdone_'.$pType); ?>
        </div>

      <?php } ?>
  <?php } else {?>
    <div>
      <?php echo __("Sorry but this url is invalid and you can't like."); ?>
    </div>
  <?php } ?>
  </div>
  <div id="twocol_right_short_add" class="content_main_border rounded_corners light_background right" >
    <h3><?php echo __('ADD_FURTHER_NETWORKS', null, 'widget'); ?></h3>
    <p><?php echo __('CURRENT_NETWORKS', null, 'widget'); ?></p>

    <ul class="normal_list" id="services_to_choose">
      <li><a id="choose_facebook" href="<?php echo url_for("@static_signinto?service=facebook", true); ?>">Facebook</a></li>
      <li><a id="choose_twitter" href="<?php echo url_for("@static_signinto?service=twitter", true); ?>">Twitter</a></li>
      <li><a id="choose_linkedin" href="<?php echo url_for("@static_signinto?service=linkedin", true); ?>">LinkedIn</a></li>
      <li><a id="choose_google" href="<?php echo url_for("@static_signinto?service=google", true); ?>">Google</a></li>
    </ul>
  </div>


  <div id="twocol_right_empty" class="content_main_border rounded_corners light_background right" style="display: none;">
    <?php echo __('NO_FURTHER_NETWORKS', array('%1' => mail_to('neu@yiid.it')), 'widget'); ?>
  </div>

</div>

<div id="see_friends_actions" class="clearfix">
  <a href="http://www.yiid.com" target="_blank"><?php echo __('YOUR_FRIENDS_LIKES', null, 'widget'); ?></a>
</div>

<iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?visible=false&url=dummy" border="none" width="0px" height="0px" style="border:none;width:0px;height:0px;"></iframe>