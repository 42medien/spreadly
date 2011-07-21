WidgetDealForm.init();

i18n.init({
	"deal_error_message": "<?php echo __("Something went wrong! Check your selected services and try again!");?>",
	"deal_success_headline": "<?php echo __("Congratulation");?>"
});

<?php if(!$sf_user->checkDealCredentials() || !$sf_user->isAuthenticated()) { ?>
	WidgetAddService.init();
<?php } ?>