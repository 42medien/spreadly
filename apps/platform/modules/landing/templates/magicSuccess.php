<div id="signin_area">
  <div id="signin_via_services">
    <h3><?php echo __('Great, now let\'s do some magic, %1!', array('%1' => 'Thomas'), "platform"); ?></h3>
    <p><?php echo __('We will try to find other profiles of you on the web.', null, 'platform'); ?></p>

    <form action="<?php echo url_for('@homepage'); ?>" method="post">
	    <div class="two_block_area clearfix" id="magic_after_registration">
	      <div class="left_block left">
	        <p class="text_important"><?php echo __('Let us show you what else we can find about you on the web. You only have to tell us the usernames you generally use.<br/><br/>You can build a richer profile and share more things with your friends by bringing all your accounts together in one place.', null, 'platform'); ?></p>
		    </div>
		    <div class="right_block right">
		      <div class="clearfix">
	          <input type="checkbox" id="name1" />
	          <label for="name1">thuhn</label>
	        </div>
	          
	        <div class="clearfix">
            <input type="checkbox" id="name2" />
            <label for="name1">thomas.huhn</label>
          </div>
          
          <div class="clearfix">  
            <input type="checkbox" id="name3" />
            <input type="text" id="new_name" value="other username" />
            <span class="add_further_username">&nbsp;</span>
          </div>
		    </div>
	    </div>
	    
	    <div class="center_area clearfix">
	      <input type="submit" class="btn" value="<?php echo __('Next', null, 'platform'); ?>" /> <?php echo __('or', null, 'platform'); ?> <?php echo link_to(__('Skip', null, 'platform'), '@homepage'); ?>
	    </div>
    </form>
  </div>
</div>