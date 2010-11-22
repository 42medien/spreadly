<?php use_helper('Date') ?>
<div class="content-header-box" id="add-domain-profiles">
  <?php include_partial('domain_profiles/form', array('form'=> $form)); ?>
</div>

<div class="content-box">
  <?php include_partial('domain_profiles/domain_profiles_table', array('domain_profiles' => $domain_profiles)); ?>
</div>

