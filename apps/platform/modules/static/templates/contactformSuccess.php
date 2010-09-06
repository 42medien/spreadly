<div class="community-add">
	<?php //include_component('components', 'error_msg') ?>
	<?php //include_component('components', 'info_msg') ?>
	<div><?php echo __('CONTACT_DESCRIPTION', null, 'help'); ?></div>
	<div id="contactform" class="clearfix">
	  <form action="<?php echo url_for('static/contactform') ?>" method="POST">

	    <div class="clearfix">
		    <?php echo $form['name']->renderLabel(array(), array('class' => 'left')); ?>
		    <?php echo $form['name']->render(array('class' => 'left')); ?>
		  </div>

		  <div class="clearfix">
	      <?php echo $form['email']->renderLabel(array(), array('class' => 'left')); ?>
	      <?php echo $form['email']->render(array('class' => 'left')); ?>
	    </div>

	    <div class="clearfix">
	      <?php echo $form['subject']->renderLabel(array(), array('class' => 'left')); ?>
	      <?php echo $form['subject']->render(array('class' => 'left')); ?>
	    </div>

	    <div class="clearfix">
	      <?php echo $form['message']->renderLabel(array(), array('class' => 'left')); ?>
	      <?php echo $form['message']->render(array('class' => 'left')); ?>
	    </div>

	    <div class="clearfix">
        <label for="submit" class="left">&nbsp;</label>
        <input type="submit" class="button small green left" value="<?php echo __('SUBMIT'); ?>" />
      </div>
	  </form>
	</div>
</div>