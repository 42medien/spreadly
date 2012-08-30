<?php slot('content') ?>
  	<?php if($pIsNew) { ?>
    	<h3 class="verifytitle"><?php echo __('Deal Successfully Created!')?></h3>
    <?php } else { ?>
    	<h3 class="verifytitle"><?php echo __('Deal Successfully Updated!')?></h3>
    <?php } ?>
	  	<p>
	  		<?php if($pIsNew) { ?>
	  			<strong><?php echo __('Please allow up to 24 hours for your deal to be processed.'); ?></strong>
		    <?php } else { ?>
		    	<strong><?php echo __('Updated Deals have to run through our approval process again. Please allow up to 24 hours for your deal to be processed.'); ?></strong>
		    <?php } ?>
	  	</p>
	  	<?php if($pIsNew) { ?>
		    <p>
		      <?php echo __("If you don't have any Spreadly buttons on your site yet, you can use the %getbutton%", array('%getbutton%' => link_to(__('button wizard to create and put them on your site now'), '@configurator'))); ?><br />
		      <span class="meta-text">
		      	<?php echo __('Those buttons will transform automatically into deal buttons during the runtime of your deal campaign and will switch back to their default settings again after the end of your deal.'); ?>
		      </span>
		    </p>
	    <?php } ?>
	    <p>
	    	<?php echo link_to('<span>'.__('Close').'</span>', 'deals/get_create_index', array('class' => 'alignleft button link-deal-content')); ?>
				<?php echo link_to('<span>'.__('Create another deal').'</span>', 'deals/get_create_form', array('class' => 'alignleft button link-deal-content')); ?>
	    </p>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>