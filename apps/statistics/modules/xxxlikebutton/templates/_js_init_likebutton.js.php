Yiidit.init();
ConfigWizard.init("<?php echo $sf_user->getCulture(); ?>", "<?php echo sfConfig::get('app_settings_url'); ?>/flash/ZeroClipboard.swf");
i18n.init({'like_en': 'I like it', 'like_de': 'Mir gefällt das', 'like_tr': 'Ben beġendim'});