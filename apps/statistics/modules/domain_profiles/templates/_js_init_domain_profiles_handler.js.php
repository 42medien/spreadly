DomainProfilesHandler.init();
i18n.set('DELETE_DOMAIN', '<?php echo __('You wanna realy delete this website from analytics?'); ?>');
jQuery("select.custom-select").jgdDropdown();

DomainProfilesHandler.aClipboardPath = "<?php echo sfConfig::get('app_settings_url'); ?>/flash/ZeroClipboard.swf";
/*CouponCode.initClipboard("<?php echo sfConfig::get('app_settings_url'); ?>/flash/ZeroClipboard.swf");*/