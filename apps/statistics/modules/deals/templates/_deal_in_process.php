  <div id="create-deal-content">
		<div class="content-header-box" id="creat-deal-box">
		  <div class="content-box-head">
		    <h3><?php echo __('+ Deal Successfully Created!')?></h3>
	  </div>
	  <div class="content-box-body" id="claiming-profile-content">
	  	<p>
	  		<strong><?php echo __('Please allow up to 24 hours for your deal to be processed.'); ?></strong>
	  	</p>
	    <p class="yellow meta-info-box">
	      <?php echo __('If you <strong>don\'t</strong> have any yiid buttons on your site yet, you can use the %getbutton%', array('%getbutton%' => link_to('button wizard to create and put them on your site now »', 'likebutton/index'))); ?><br />
	      <span class="meta-text">
	      	<?php echo __('Those buttons will transform automatically into deal buttons during the runtime of your deal campaign and will switch back to their default settings again after the end of your deal.'); ?>
	      </span>
	    </p>
	    <p>
	    	<?php echo link_to('Close', 'deals/get_create_index', array('class' => 'link-deal-content')); ?>
	    	&nbsp;&nbsp;&nbsp;<?php echo __('or'); ?>&nbsp;&nbsp;&nbsp;
				<?php echo link_to('Create another deal', 'deals/get_create_form', array('class' => 'link-deal-content')); ?>
	    </p>
	  </div>
	</div>
</div>