<?php if(!$sf_user->isAuthenticated()): ?>

  <?php echo $form->renderFormTag(url_for('@sf_guard_signin'), array('id'=>'signin_form')); ?>
    <?php echo $form[$form->getCSRFFieldName()]->render(); ?>
    
    <label class="textfield-whtmid">
      <span>
        <input type="text" class="wd172" id="signin_username" value="<?php echo __('Username or email'); ?>" name="signin[username]">
      </span>
    </label>
    <label class="textfield-whtmid" style="margin-left:10px">
      <span>
        <input type="password" class="wd172" id="signin_password" value="<?php echo __('Password'); ?>" name="signin[password]">
      </span>
    </label>
    
    <button type="submit" id="signin_submit" class="button"><span><?php echo __('Login'); ?></span></button>
    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_register'])): ?>
      <span class="navigation_text" id="nav_register">
        <?php echo __('or'); ?> <?php echo link_to(__('Register'), '@sf_guard_register', array('rel' => 'facebox')); ?>
      </span>
    <?php endif; ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <span class="navigation_text" id="nav_forgot_pw">
        |
        <?php echo link_to(__('Password forgotten?'), '@sf_guard_forgot_password', array('rel' => 'facebox')); ?>
      </span>
    <?php endif; ?>
  </form>

<?php endif; ?>
