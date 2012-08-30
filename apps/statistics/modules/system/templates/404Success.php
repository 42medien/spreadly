<?php slot('content') ?>
  <h2><?php echo __('Sorry! This site does not exist within Spreadly. '); ?></h2>
  <p class="text_important"><?php echo __('Please visit the %1 or send us a contact mail.', array('%1' => link_to(__('Spreadly welcome page'), '@homepage'))); ?></p>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>