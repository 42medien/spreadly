<div id="claim_site_area" class="area_border">
  <form action="<?php echo url_for('@like_get_code'); ?>" id="claim_site_form" class="clearfix">
    <div class="clearfix">
		  <label for="claim_url"><?php echo __('Claim that you own the site'); ?></label>
		  <input type="text" id="claim_url" name="claim[url]" value="<?php echo __('URL'); ?>" />
		  
		  <p class="important_text"><?php echo __("We need to make sure that only you get access to your sites analytics. That's why you have to choose and execute one of the following verification methods:"); ?></p>
    </div>
	        
	  <ul class="clearfix">
	    <li>
	      <input type="radio" name="claim[type]" id="claim_type_1" value="1" />
	      <label for="claim_type_1"><?php echo __('via Meta Tag'); ?></label>
	      <p><?php echo __("Insert the following meta tag somewhere between &lt;header&gt; and &lt;/header&gt; in the source code of your homepage:"); ?></p>
	      <p>&lt;meta ... /&gt;</p>
	    </li>
      <li>
        <input type="radio" name="claim[type]" id="claim_type_2" value="2" />
        <label for="claim_type_2"><?php echo __('via Image'); ?></label>
        <p><?php echo __("Insert the following image somewhere between &lt;body&gt; and &lt;/body&gt; in the source code of your homepage:"); ?></p>
        <p>&lt;img ... /&gt;</p>
      </li>
      <li>
        <input type="radio" name="claim[type]" id="claim_type_3" value="3" />
        <label for="claim_type_3"><?php echo __('via File Upload'); ?></label>
        <p><?php echo __("Upload a file to the webroot of your server and make it accessible. The filename has to be as follows:"); ?></p>
        <p>yiid_97327193101901723120.html</p>
      </li>
	  </ul>
    
    <div id="button_get_code_outer" class="left">
      <input type="submit" id="button-likebutton" class="submit-button" value="<?php echo __('Verify'); ?>">
    </div>
    
    <div class="normal_button right" id="claim_button2">
      <a href="/"><?php echo __('No thanks, just the code please'); ?></a>
    </div>
  </form>
</div>