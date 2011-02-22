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
  <form action="<?php echo url_for('@like_get_code'); ?>" autocomplete="off" name="staticbuttonform" id="staticbutton-form" class="clearfix">
    <div id="button_url" class="clearfix">
      <div class="radio_area left">
        <label for="static_button_url"><?php echo __('URL'); ?></label>
      </div>
      <div class="yiid-widget left">
        <input type="text" name="static_button[url]" id="static_button_url" value="<?php echo __('URL of your site'); ?>" />
      </div>
    </div>

    <div class="left" id="preview_widgets">
      <h3><?php echo __('Static Image Button'); ?></h3>

      <div class="clearfix">
        <div class="clearfix">
	        <div class="radio_area left">
	          <input type="radio" name="static_button[text]" id="static_button_img" value="img" class="left widget-radio" checked/>
	        </div>
	        <div class="yiid-widget left" id="static-button-preview">
	          <?php include_partial('likebutton/img_code', array('pWidgetSize'=>0 ,'pUrl' => 'http://www.yiid.com', 'pText'=> null, 'pLang' => $lUserCulture)); ?>
	          <?php //echo image_tag('/img/global/yiid-btn-full-'.$lUserCulture); ?>
	        </div>
	      </div>
        <p><?php echo __('No counts for likes or dislikes and no social functions.'); ?></p>
        <p><?php echo __("Is the appropriate option, if you want to put the button in newsletters, forums or other sites that don't allow html for iframes."); ?></p>
      </div>

      <br/>
      <h3><?php echo __('Text only version'); ?></h3>

      <div class="clearfix">
        <div class="radio_area left">
          <input type="radio" name="static_button[text]" value="text" id="static_button_text_radio" class="left widget-radio"/>
        </div>
        <div class="yiid-widget left">
          <?php echo __('Choose your own wording!'); ?><br/>
          <input type="text" name="static_button[text_value]" id="static_button_text_value" value="I like this!" />
        </div>
      </div>
    </div>

    <div class="left" id="choose_style_middle">
        <h3><?php echo __('Optional Parameters'); ?></h3>

        <div class="clearfix">
          <select name="static_button[l]" id="staticbutton_l">
            <option value="de" <?php if($lUserCulture == 'de') {?>selected="selected" <?php } ?>><?php echo __('SELECT_LANGUAGE_DE', null, 'configurator'); ?></option>
            <option value="en" <?php if($lUserCulture == 'en') {?>selected="selected" <?php } ?>><?php echo __('SELECT_LANGUAGE_EN', null, 'configurator'); ?></option>
            <option value="tr" <?php if($lUserCulture == 'tr') {?>selected="selected" <?php } ?>><?php echo __('Turkish'); ?></option>
          </select>
        </div>

        <!--
        <div class="clearfix" id="select-type">
          <?php //include_partial('likebutton/select_type', array('pCulture' => $lUserCulture)) ?>
        </div>
         -->

        <!--
        <div class="clearfix">
          <input type="text" name="likebutton[w]" id="likebutton_w" value="<?php // echo __('VALUE_WIDTH', null, 'configurator'); ?>" />
        </div>
         -->

        <div class="clearfix">
          <input type="checkbox" name="static_button[bt]" id="staticbutton_bt" class="left" /><label for="staticbutton_bt" class="left"><?php echo __('HELP_DISLIKE_OPTION', null, 'configurator'); ?></label>
        </div>
    </div>

    <div class="left" id="choose_style_right">
      <h3><?php echo __('Your Code'); ?></h3>

      <div class="clearfix">
	      <textarea id="your_static_code" class="left"><?php include_partial('likebutton/img_code', array('pWidgetSize'=>0 ,'pUrl' => 'http://www.yiid.com', 'pText'=> null, 'pLang' => $lUserCulture)); ?>
	      </textarea>

        <div id="button_get_stat_code_outer" class="left my_clip_button">
	        <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('Copy Code to Clipboard'); ?>">
	      </div>
	    </div>

      <div class="clearfix">
        <?php echo link_to(__("Optional: register to get your statistics, it's free!"), "/"); ?>
      </div>
    </div>
  </form>
</div>