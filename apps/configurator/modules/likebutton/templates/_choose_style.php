<?php
  $lSessionUser = sfContext::getInstance()->getUser();
  $lUserCulture = $lSessionUser->getCulture();
?>

<div id="choose_style_area">
  <form action="<?php echo url_for('@like_get_code'); ?>" autocomplete="off" name="likebuttonform" id="likebutton-form" class="clearfix">
		<div class="half left">
			<h3><?php echo __('Standard Size'); ?></h3>
			
			<div class="clearfix">
			  <div class="radio_area left">
	        <input type="radio" name="widget[type]" value="1" class="left" />
	      </div>
	      <div id="yiid-widget-1" class="yiid-widget left">     
	        <?php include_partial('likebutton/widget_like', array('pUrl' => 'http://www.yiid.com', 'pLang' => 'de', 'pWidth'=>'400', 'pHeight'=>'25', 'pType'=>'like', 'pFontColor'=>'#000000', 'pShort'=>'', 'pSocial'=>'')); ?>
	      </div>
		  </div>
			
			<div class="clearfix">
	      <div class="radio_area left">
	        <input type="radio" name="widget[type]" value="2" class="left" />
	      </div>
	      <div id="yiid-widget-2" class="yiid-widget left">     
	        <?php include_partial('likebutton/widget_like', array('pUrl' => 'http://www.yiid.com', 'pLang' => 'de', 'pWidth'=>'400', 'pHeight'=>'25', 'pType'=>'like', 'pFontColor'=>'#000000', 'pShort'=>'', 'pSocial'=>'')); ?>
	      </div>
		  </div>
			
			<br/>
			<h3><?php echo __('Small Size'); ?></h3>
	    
	    <div class="clearfix">
	      <div class="radio_area left">
	        <input type="radio" name="widget[type]" value="3" class="left" />
	      </div>
	      <div id="yiid-widget-3" class="yiid-widget left">     
	        <?php include_partial('likebutton/widget_like', array('pUrl' => 'http://www.yiid.com', 'pLang' => 'de', 'pWidth'=>'400', 'pHeight'=>'25', 'pType'=>'like', 'pFontColor'=>'#000000', 'pShort'=>'1', 'pSocial'=>'')); ?>
	      </div>
	    </div>
	    
	    <div class="clearfix">
	      <div class="radio_area left">
	        <input type="radio" name="widget[type]" value="4" class="left" />
	      </div>
	      <div id="yiid-widget-4" class="yiid-widget left">     
	        <?php include_partial('likebutton/widget_like', array('pUrl' => 'http://www.yiid.com', 'pLang' => 'de', 'pWidth'=>'400', 'pHeight'=>'25', 'pType'=>'like', 'pFontColor'=>'#000000', 'pShort'=>'1', 'pSocial'=>'')); ?>
	      </div>
	    </div>
		</div>
		
		<div class="half left" id="choose_style_right">
		  <h3><?php echo __('Options'); ?></h3>
		
		  <div class="clearfix">
			  <select name="likebutton[l]" id="likebutton_l">
			    <option value="de" selected="selected"><?php echo __('SELECT_LANGUAGE_DE', null, 'configurator'); ?></option>
			    <option value="en"><?php echo __('SELECT_LANGUAGE_EN', null, 'configurator'); ?></option>
			    <option value="tr"><?php echo __('Turkish'); ?></option>
			  </select>
			</div>
		  
		  <div class="clearfix">
		    <?php include_partial('likebutton/select_type', array('pCulture' => $lUserCulture)) ?>
		  </div>
		  
		  <div class="clearfix">
		    <input type="text" name="likebutton[fc]" id="likebutton_fc" value="#000000" />
		  </div>
		  
		  <div class="clearfix">
		    <input type="text" name="likebutton[w]" id="likebutton_w" value="<?php echo __('VALUE_WIDTH', null, 'configurator'); ?>" />
		  </div>
		  
		  <div class="clearfix">
		    <input type="checkbox" name="likebutton[bt]" id="likebutton_bt" /><label for="likebutton_bt"><?php echo __('HELP_DISLIKE_OPTION', null, 'configurator'); ?></label>
		  </div>
		  
		  <div id="button_get_code_outer" class="right">
		     <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('BUTTON_GET_CODE', null, 'configurator'); ?>">
		   </div>
		</div>
	</form>
</div>