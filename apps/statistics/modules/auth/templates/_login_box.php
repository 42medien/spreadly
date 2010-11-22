<?php if(!$sf_user->isAuthenticated()): ?>

  <?php echo $form->renderFormTag(url_for('@sf_guard_signin'), array('id'=>'signin_form')); ?>
    <?php echo $form[$form->getCSRFFieldName()]->render(); ?>
    <?php echo $form['username']->render(array('value'=>__('Username or email'))); ?>
    <?php echo $form['password']->render(array('value'=>__('Password'))); ?>
    <input type="submit" id="signin_submit" class="button positive inline" value="<?php echo __('Login'); ?>" />
    <?php $routes = $sf_context->getRouting()->getRoutes() ?>
    <?php if (isset($routes['sf_guard_register'])): ?>
      <span class="navigation_text" id="nav_register">
        <?php echo __('or'); ?> <?php echo link_to(__('Register'), '@sf_guard_register', array('rel' => 'facebox')); ?>
      </span>
    <?php endif; ?>
    <?php if (isset($routes['sf_guard_forgot_password'])): ?>
      <span class="navigation_text" id="nav_forgot_pw">
        <?php echo link_to(__('Password forgotten?'), '@sf_guard_forgot_password', array('rel' => 'facebox')); ?>
      </span>
    <?php endif; ?>
  </form>

<?php endif; ?>
