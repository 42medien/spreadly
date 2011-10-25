<?php use_helper('I18N') ?>
<?php use_stylesheets_for_form( $form ) ?>
<?php
  // Override the login slot so that we don't get a login prompt on the
  // apply page, which is just odd-looking. 0.6
?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php slot('content') ?>
<div class="sf_apply sf_apply_apply">
  <h3 class="verifytitle"><?php echo __("&raquo; Apply for an Account", array(), 'sfForkedApply') ?></h3>

  <form method="post" action="<?php echo url_for('sfApply/apply') ?>" name="sf_apply_apply_form" id="sf_apply_apply_form">
  <table>
    <tbody>
      <?php echo $form ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">
          <div class="clearfix">
            <button type="submit" class="button alignleft"><span><?php echo __("Create My Account", array(), 'sfForkedApply') ?></span></button>
            <?php echo link_to('<span>'.__("Cancel", array(), 'sfForkedApply').'</span>', sfConfig::get('app_sfApplyPlugin_after', '@homepage'), array('class' => 'button alignleft')) ?>
          </div>
        </td>
      </tr>
    </tfoot>
  </table>

  </form>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox', array('pClass' => 'register-box')); ?>