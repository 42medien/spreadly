NoUrlForm.init();
//jQuery(".likecheckbox").custCheckBox();
i18n.init({
	"like_success_message": "<?php echo __("Like successfully sent!");?>",
	"like_error_message": "<?php echo __("Something went wrong! Check your selected services and try again!");?>"
});

<?php if(!$sf_user->isAuthenticated()) { ?>
	WidgetAddService.init();
<?php } ?>
