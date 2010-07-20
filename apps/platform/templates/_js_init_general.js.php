console.log("Info [platform][jsinit_general.js.php]");
ErrorHandler.catchGlobalError();
ErrorHandler.aDev = "<?php echo sfConfig::get('app_settings_dev'); ?>";

GlobalRequest.bindClickByClass('friends_active_list','stream_filter');
GlobalRequest.bindClickByClass('all_networks_list','stream_filter');
GlobalRequest.bindClickByClass('main_nav_outer','main_filter');


