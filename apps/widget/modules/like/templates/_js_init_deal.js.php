//jQuery("input.dealcheckbox").custCheckBox();
//jQuery("input[type='checkbox']").custCheckBox();
WidgetDealForm.init();
<?php if(!$sf_user->isAuthenticated()) { ?>
	WidgetAddService.init();
<?php } ?>