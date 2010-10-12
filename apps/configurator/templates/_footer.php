<div id="nav_supp" class="clearfix">
  <?php echo link_to(__('TERMS_OF_SERVICE', null, 'configurator'), $sf_context->getConfiguration()->generatePlatformUrl('tos')); ?>
  <?php echo link_to(__('PRIVACY', null, 'configurator'), $sf_context->getConfiguration()->generatePlatformUrl('privacy')); ?>
  <?php echo link_to(__('Imprint'), $sf_context->getConfiguration()->generatePlatformUrl('imprint')); ?>
  <?php echo link_to(__('Webmasters &amp; Developers'), '@webmasters'); ?>
  <?php echo mail_to('info@yiid.com'); ?>
</div>