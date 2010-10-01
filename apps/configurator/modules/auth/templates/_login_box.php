<form action="<?php echo url_for('@signin'); ?>" method="POST" id="signin_form">
  <input type="text" name="email" id="email" value="<?php echo __('Email'); ?>" />
  <input type="password" name="password" id="password" value="<?php echo __('Password'); ?>" />
  <input type="submit" id="signin_submit" value="<?php echo __('Login'); ?>" />
  <span class="navigation_text" id="nav_register">  
    <?php echo __('or'); ?> <?php echo link_to(__('Register'), '@register'); ?>
  </span>
  <span class="navigation_text" id="nav_forgot_pw">
    <?php echo link_to(__('Password forgotten?'), '@forgot_password', array('rel' => 'facebox')); ?>
  </span>
</form>