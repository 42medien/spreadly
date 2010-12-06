<?php use_helper('Text'); ?>

<div class="content-box rounded_corners">
  <?php if($pIsUrlValid) { ?>
    <div id="so_right_view" class="clearfix">
      <div id="so_detail_desc" class="clearfix">
        <img alt="<?php echo $pUrl; ?>" width="100px" height="80px" src="<?php if(!$pImageUrl){ ?>http://communipedia.v2.websnapr.com/?url=<?php echo $pUrl; ?>&sh=80&sw=100<?php } else { echo $pImageUrl; } ?>" class="left">

        <h3 class="small_margin" title="<?php echo $pTitle; ?>"><?php echo truncate_text($pTitle, 30, '...'); ?></h3>
        <p title="<?php echo $pUrl; ?>"><?php echo link_to(UrlUtils::getShortUrl($pUrl), $pUrl, array('class' => 'url')); ?></p>
        <span class="normal_text"><?php echo truncate_text($pDescription, 400, '...'); ?></span>
      </div>
    </div>

    <?php if ($pIsUsed) { ?>
      <?php include_partial("deal_info", array("pYiidActivity" => $pYiidActivity, "pDeal" => $pDeal)); ?>
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
      <?php } ?>
	    <?php } else { ?>
	      <?php include_partial("deal_offer", array("pDeal" => $pDeal)); ?>
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
		            <?php echo truncate_text($lIdentity->getName(), 25, '...'); ?>
		          </label>
		        </li>
		      <?php } ?>
		      </ul>
		      <div class="rounded_corners content_main_border popup_button distance_right" id="static-like-button">
            <span class="sharing_button likeit_button">&nbsp;</span>
            <?php echo __($pType); ?>
          </div>
          <?php if($pFull) {?>
	          <div class="rounded_corners content_main_border popup_button" id="static-dislike-button">
	            <span class="sharing_button dislikeit_button" id="static-dislike-button">&nbsp;</span>
	          </div>
          <?php } ?>
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

<div id="see_friends_actions" class="clearfix">
  <a href="http://www.yiid.com" target="_blank"><?php echo __('YOUR_FRIENDS_LIKES', null, 'widget'); ?></a>
</div>

<iframe src="http://widgets.<?php echo sfConfig::get("app_settings_host"); ?>/w/like/like.php?visible=false&url=dummy" border="none" width="0px" height="0px" style="border:none;width:0px;height:0px;"></iframe>