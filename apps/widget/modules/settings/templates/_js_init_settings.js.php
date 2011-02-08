ShareDefaultSettings.resetForm();
jQuery("input[type='radio'],input[type='checkbox']").custCheckBox({
	callback: ShareDefaultSettings.toggleService
});