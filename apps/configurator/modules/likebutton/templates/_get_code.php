<div id="get_code_area">
  <div class="one_quarter left">
    <form action="auth/signin" method="POST">
      <h4><?php echo __('Login'); ?></h4>
      <div class="clearfix">
        <input type="text" name="user[email]" value="<?php echo __('Email'); ?>" />
      </div>
      <div class="clearfix">
        <input type="password" name="user[password]" value="<?php echo __('Password'); ?>" />
      </div>
      <div class="clearfix">
        <input type="submit" value="<?php echo __('Login'); ?>" />
      </div>
    </form>
  </div>
  <div class="one_quarter left">
    <form action="auth/signin" method="POST">
      <h4><?php echo __('Register'); ?></h4>
      <div class="clearfix">
        <input type="text" name="user[name]" value="<?php echo __('Name'); ?>" />
      </div>
      <div class="clearfix">
        <input type="text" name="user[email]" value="<?php echo __('Email'); ?>" />
      </div>
      <div class="clearfix">
        <input type="password" name="user[password]" value="<?php echo __('Password'); ?>" />
      </div>
      <div class="clearfix">
        <input type="password" name="user[password_repeat]" value="<?php echo __('Repeat Password'); ?>" />
      </div>
      <div class="clearfix">
        <input type="submit" value="<?php echo __('Register'); ?>" />
      </div>
    </form>
  </div>
  <div class="half left">
    <h4><?php echo __('Register'); ?></h4>
    <h3><?php echo __('Get the perfect view on'); ?></h3>
    <ul>
      <li><?php echo __('where your users come from'); ?></li>
      <li><?php echo __('what services they use'); ?></li>
      <li><?php echo __('what demographics they have (age, gender etc.)'); ?></li>
      <li><?php echo __('what language they speak'); ?></li>
      <li><?php echo __('new and recurring users'); ?></li>
      <li><?php echo __('and much more ...'); ?></li>
    </ul>
    <p><?php echo link_to(__('No thanks, just the code please'), '/'); ?></p>
  </div>
</div>