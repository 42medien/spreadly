
<?php $lDeal = $pActivity->getDeal();?>
	<div class="coupon shadow-light bordered-light clearfix">
		<?php echo image_tag($lDeal->getImageUrl(), array('class' => 'alignleft deal-coupon-img')); ?>
		<div class="alignleft" id="coupon-text">
			<?php echo $pActivity->getCCode(); ?>
		</div>
	</div>