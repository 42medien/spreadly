<?php use_helper('I18N') ?>
<?php slot('sf_apply_login') ?>
<?php end_slot() ?>
<?php slot('content') ?>
<div class="sf_apply_notice">
<p>
  Ihr Zugang ist nicht aktiv. Bitte kontaktieren Sie den Administator. 
This account is inactive. Please contact the administrator. 
info@spreadly.com
</p>
<?php include_partial('sfApply/continue') ?>
</div>
<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
