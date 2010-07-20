<?php use_helper('Headline'); ?>

<?php echo green_headline(__('HEADLINE_WEBMASTERS', null, 'configurator'), 20, 60); ?>
<div id="conf_content">
  
  <div id="conf_content_supp" class="light_border_right_side big_size">
  
    <div id="widget_choice">
	    <input type="radio" name="like_only" onclick="Configurator.toggleGenericCode(0)" value="0" id="like" class="left" /><label for="like" class="radio_label left"><?php echo __('LIKE', null, 'configurator'); ?></label>
	    <input type="radio" name="like_only" onclick="Configurator.toggleGenericCode(1)" value="1" checked="checked" id="like_dislike" class="left" /><label for="like_dislike" class="radio_label left"><?php echo __('LIKE_DISLIKE', null, 'configurator'); ?></label>
	  </div>
  
    <textarea id="generic_code_like" style="display:none;"><iframe scrolling="no" frameborder="0" marginwidth="0" marginheight="0" style="overflow: hidden; width: 400px; height: 30px;" src="http://widgets.yiid.com/w/like/like.php?cult={language}&type={like}&url={permalink}" allowtransparency="true"></iframe></textarea>
    <textarea id="generic_code_like_dislike"><iframe scrolling="no" frameborder="0" marginwidth="0" marginheight="0" style="overflow: hidden; width: 400px; height: 30px;" src="http://widgets.yiid.com/w/like/full.php?cult={language}&type={like}&url={permalink}" allowtransparency="true"></iframe></textarea>
  
    <p class="important_text"><?php echo __('CONFIGURATOR_HELP_TEXT', array('%1' => link_to(__('CONFIGURATOR', null, 'configurator'), '@homepage')), 'configurator'); ?></p>
  
    <div class="widget_parameters">
	    <p class="important_text"><?php echo __('MANDATORY_PARAMETERS', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">cult:</span> <?php echo __('INTERNATIONAL_COUNTRY_CODE', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">type:</span>  <?php echo __('BUTTON_TEXT', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">url:</span> <?php echo __('LIKE_URL', null, 'configurator'); ?></p>
	  </div>
    
    <div class="widget_parameters">
	    <p class="important_text"><?php echo __('OPTIONAL_PARAMTERS', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">color:</span>  <?php echo __('DEFAULT_COLOR', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">title:</span> <?php echo __('PAGE_TITLE', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">description:</span> <?php echo __('CONTENT_SUMMARY', null, 'configurator'); ?></p>
	    <p><span class="italic_text underlined_text">photo:</span> <?php echo __('PHOTO_URL', null, 'configurator'); ?></p>
	  </div>
	  
	  <p><?php echo __('MAXIMUM_LENGHT', null, 'configurator'); ?></p>
  </div>
	 
</div>


