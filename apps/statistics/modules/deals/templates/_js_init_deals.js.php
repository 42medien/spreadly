
//ErrorHandler.catchGlobalError();
i18n.init({
	'COUPON_TYPE_URL_LABEL': '<?php echo __('COUPON_TYPE_URL_LABEL'); ?>',
	"COUPON_TYPE_URL_VALUE": '<?php echo __('Insert valid Url e.g. http://www.example.com'); ?>',
	"COUPON_TYPE_SINGLE_LABEL": "<?php echo __('COUPON_TYPE_SINGLE_LABEL'); ?>",
	"COUPON_TYPE_SINGLE_VALUE": "<?php echo __('Coupon Code'); ?>"
});


jQuery("input[type='checkbox']").custCheckBox();
//jQuery('.mirror-change-value').mirrorChangeValue();
Deal.init();
//DealTable.init();
DealForm.init();
//AnalyticsFilter.init();


