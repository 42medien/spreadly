<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<div class="sf_apply sf_apply_apply">
<h2 class="green_style"><?php echo __("&raquo; Apply for an Account", array(), 'sfForkedApply') ?></h2>
<form method="post" action="<?php echo url_for('sfApply/apply') ?>" name="sf_apply_apply_form" id="sf_apply_apply_form">
<table>
  <tbody>
    <?php echo $form ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="2">
        <div class="clearfix">  
          <input type="submit"class="button positive" value="<?php echo __("Create My Account", array(), 'sfForkedApply') ?>" />
          <?php echo link_to(__("Cancel", array(), 'sfForkedApply'), sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'button')) ?>
        </div>
      </td>
    </tr>
  </tfoot>
</table>

</form>
</div>
