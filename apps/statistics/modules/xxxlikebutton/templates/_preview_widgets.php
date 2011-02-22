<?php

  if(!isset($pWidgetType)) $pWidgetType = '';
  if(!isset($pLang)) $pLang = '';
  if(!isset($pWidth)) $pWidth = '';
  if(!isset($pType)) $pType = '';
  if(!isset($pFontColor)) $pFontColor = '';

?>

      <h3><?php echo __('Standard Size'); ?></h3>

      <div class="clearfix">
        <div class="radio_area left">
          <input type="radio" name="likebutton[wt]" value="stand" class="left widget-radio" <?php if($pWidgetType == 'stand') { ?>checked<?php } ?>/>
        </div>
        <div id="yiid-widget-1" class="yiid-widget left">
          <?php include_partial('likebutton/widget_like', array('pUrl' => $pUrl, 'pLang' => $pLang, 'pWidth'=>$pWidth, 'pHeight'=>'25', 'pType'=>$pType, 'pFontColor'=>$pFontColor, 'pShort'=>'', 'pSocial'=>'')); ?>
        </div>
      </div>

      <div class="clearfix">
        <div class="radio_area left">
          <input type="radio" name="likebutton[wt]" value="stand_social" class="left widget-radio" <?php if($pWidgetType == 'stand_social') { ?>checked<?php } ?>/>
        </div>
        <div id="yiid-widget-2" class="yiid-widget left">
          <?php include_partial('likebutton/widget_like', array('pUrl' => $pUrl, 'pLang' => $pLang, 'pWidth'=>$pWidth, 'pHeight'=>'65', 'pType'=>$pType, 'pFontColor'=>$pFontColor, 'pShort'=>'', 'pSocial'=>1)); ?>
        </div>
      </div>

      <br/>
      <h3><?php echo __('Small Size'); ?></h3>

      <div class="clearfix">
        <div class="radio_area left">
          <input type="radio" name="likebutton[wt]" value="short" class="left widget-radio" <?php if($pWidgetType == 'short') { ?>checked<?php } ?>/>
        </div>
        <div id="yiid-widget-3" class="yiid-widget left">
          <?php include_partial('likebutton/widget_like', array('pUrl' => $pUrl, 'pLang' => $pLang, 'pWidth'=>$pWidth, 'pHeight'=>'25', 'pType'=>$pType, 'pFontColor'=>$pFontColor, 'pShort'=>'1', 'pSocial'=>'')); ?>
        </div>
      </div>

      <div class="clearfix">
        <div class="radio_area left">
          <input type="radio" name="likebutton[wt]" value="short_social" class="left widget-radio" <?php if($pWidgetType == 'short_social') { ?>checked<?php } ?>/>
        </div>
        <div id="yiid-widget-4" class="yiid-widget left">
          <?php include_partial('likebutton/widget_like', array('pUrl' => $pUrl, 'pLang' => $pLang, 'pWidth'=>$pWidth, 'pHeight'=>'65', 'pType'=>$pType, 'pFontColor'=>$pFontColor, 'pShort'=>'1', 'pSocial'=>1)); ?>
        </div>
      </div>