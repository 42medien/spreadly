<?php if($pCountDomains == false) { ?>

	jQuery.colorbox({
		href:"/system/nodomain",
		width: "500px",
		opacity: '0.8',
		overlayClose: false,
		escKey: false,
		onComplete: function() {
			jQuery('#cboxClose').hide();
		}
	});

<?php }?>
