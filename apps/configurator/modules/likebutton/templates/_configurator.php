<?php use_helper('Headline'); ?>

<?php echo green_headline(__('CHOOSE_CONFIGURATOR_OPTIONS', null, 'configurator'), 20, 75); ?>
<div id="conf_content">
  
  <div id="conf_content_supp" class="light_border_right_side">
  
    <?php echo link_to(__('CHOOSE_PLUGINS', null, 'configurator'), '@webmasters', array('class' => 'normal_size')); ?>
  
    <h3 id="preview_head"><?php echo __('CONFIGURATOR_PREVIEW', null, 'configurator'); ?></h3>
    <div id="preview">
      <div id="yiid-widget">     
		    <?php include_partial('likebutton/widget_like', array('pUrl' => 'http://www.yiid.com', 'pLang' => 'de', 'pWidth'=>'420', 'pType'=>'like', 'pFontColor'=>'#000000')); ?>
		  </div>
    </div>
  
    <form action="<?php echo url_for('@like_get_code'); ?>" autocomplete="off" name="likebuttonform" id="likebutton-form" class="clearfix">
  
      <?php include_partial('likebutton/widget_form'); ?>
      
	  </form>
  
  </div>
	 
	 <div id="button_get_code_outer">
	   <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('BUTTON_GET_CODE', null, 'configurator'); ?>">
	 </div>
	 
	 <?php echo link_to(__('PLEASE_TAKE_CARE', null, 'configurator'), '@webmasters', array('class' => 'normal_size', 'id' => 'webmasters_advice')); ?>
	 
</div>


