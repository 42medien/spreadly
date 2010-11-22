<?php
  $lSessionUser = sfContext::getInstance()->getUser();
  $lUserCulture = $lSessionUser->getCulture();


  if(!isset($pUrl)) $pUrl = 'http://www.yiid.com';
  if(!isset($pWidgetType)) $pWidgetType = '';
  if(!isset($pLang)) $pLang = '';
  if(!isset($pWidth)) $pWidth = '';
  if(!isset($pHeight)) $pHeight = '';
  if(!isset($pType)) $pType = '';
  if(!isset($pFontColor)) $pFontColor = '';
  if(!isset($pShort)) $pShort = '';
  if(!isset($pSocial)) $pSocial = '';
?>

<div id="choose_style_area" class="area_border">
  <form action="<?php echo url_for('@like_get_code'); ?>" autocomplete="off" name="likebuttonform" id="likebutton-form" class="clearfix">
    <div id="button_url" class="clearfix">
      <?php if($pService) {?>
        <input type="hidden" name="likebutton[service]" value="<?php echo $pService->getSlug(); ?>"/>
        <div class="yiidit_app_icon left">
          <a href="<?php echo $pService->getUrl(); ?>" id="<?php echo $pService->getSlug(); ?>_icon">&nbsp;</a>
        </div>
        <div class="left service_description">
          <?php echo __('Please configure your widget and follow the instructions on %1!', array('%1' => link_to($pService->getName(), $pService->getTutorialUrl()))); ?>
        </div>
      <?php } else { ?>
        <div class="radio_area left">
          <label for="static_button_url"><?php echo __('URL'); ?></label>
        </div>
        <div class="yiid-widget left">
          <input type="text" name="likebutton[url]" id="likebutton_url" value="<?php echo __('URL of your site'); ?>" />
        </div>
      <?php } ?>
    </div>

		<div class="left" id="preview_widgets">
		  <?php include_partial('likebutton/preview_widgets', array('pLang' => $lUserCulture)) ?>
		</div>

		<div class="left" id="choose_style_middle">
			  <h3><?php echo __('Optional Parameters'); ?></h3>

			  <div class="clearfix">
				  <select name="likebutton[l]" id="likebutton_l">
				    <option value="de" <?php if($lUserCulture == 'de') {?>selected="selected" <?php } ?>><?php echo __('SELECT_LANGUAGE_DE', null, 'configurator'); ?></option>
				    <option value="en" <?php if($lUserCulture == 'en') {?>selected="selected" <?php } ?>><?php echo __('SELECT_LANGUAGE_EN', null, 'configurator'); ?></option>
				    <option value="tr" <?php if($lUserCulture == 'tr') {?>selected="selected" <?php } ?>><?php echo __('Turkish'); ?></option>
				  </select>
				</div>

			  <div class="clearfix" id="select-type">
			    <?php include_partial('likebutton/select_type', array('pCulture' => $lUserCulture)) ?>
			  </div>

			  <div class="clearfix">
			    <input type="text" name="likebutton[fc]" id="likebutton_fc" value="#000000" />
			  </div>

	      <!--
			  <div class="clearfix">
			    <input type="text" name="likebutton[w]" id="likebutton_w" value="<?php // echo __('VALUE_WIDTH', null, 'configurator'); ?>" />
			  </div>
			   -->

			  <div class="clearfix">
			    <input type="checkbox" name="likebutton[bt]" id="likebutton_bt" class="left" /><label for="likebutton_bt" class="left"><?php echo __('HELP_DISLIKE_OPTION', null, 'configurator'); ?></label>
			  </div>
		</div>

		<div class="left" id="choose_style_right">
	    <h3><?php echo __('Your Code'); ?></h3>

      <div class="clearfix">
		    <textarea id="your_code" class="left">
		      <?php //include_partial('likebutton/widget_full') ?>
		    </textarea>

        <div id="button_get_code_outer" class="left my_clip_button">
	        <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('Copy Code to Clipboard'); ?>">
	      </div>
	    </div>

      <div class="clearfix">
        <?php echo link_to(__("Optional: register to get your statistics, it's free!"), "/"); ?>
      </div>
		</div>
  </form>
</div>