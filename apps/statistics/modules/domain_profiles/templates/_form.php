  <div class="content-box-head">
    <h3><?php echo __('Claim your sites')?></h3>
  </div>
  <div class="content-box-body" id="claiming-profile-content">
    <p>
      <?php echo __('Start claiming your sites to enable statistics tracking an other features to come. Please understand, that we can only offer access to this data after successfully verifying your ownership of a site. If you have problems with this process, please contact'); ?> <a href="mailto: info@yiid.com">info@yiid.com</a>
    </p>
    <form action="<?php echo url_for('domain_profiles/create'); ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> id="new_domain_profile_form">
    <?php if (!$form->getObject()->isNew()): ?>
      <input type="hidden" name="sf_method" value="put" />
    <?php endif; ?>
    <?php echo $form->renderHiddenFields(false) ?>
    <?php echo $form->renderGlobalErrors() ?>
    <?php echo $form['protocol']; ?> : //
    <?php echo $form['url']; ?>
    <input type="submit" class="button positive" value="<?php echo __('Save', null, 'widget');?>" />

    <?php if (!$form->getObject()->isNew()): ?>
      <?php echo link_to('Delete', '/domain_profiles/delete?id='.$form->getObject()->getId(), array('method' => 'delete', 'confirm' => 'Are you sure?', 'class' => 'button negative')) ?>
    <?php endif; ?>
    <?php //echo $form['url']->renderError() ?>
    </form>
    <p class="error" id="add-url-error"></p>
  </div>

