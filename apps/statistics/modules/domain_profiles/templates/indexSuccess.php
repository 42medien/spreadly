<?php use_helper('Date') ?>
<div id="add-domain-profiles">
  <?php include_partial('domain_profiles/form', array('form'=> $form)); ?>
</div>

<?php include_partial('domain_profiles/domain_profiles_table', array('domain_profiles' => $domain_profiles)); ?>