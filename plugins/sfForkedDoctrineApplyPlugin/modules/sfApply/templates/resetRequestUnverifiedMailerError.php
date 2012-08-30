<?php use_helper('I18N') ?>
<?php slot('content') ?>
<div class="sf_apply_notice">
<?php echo __('<p>
An error took place during the email delivery process. Please try
again later.
</p>', array(), 'sfForkedApply') ?>
<?php include_partial('sfApply/continue') ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
