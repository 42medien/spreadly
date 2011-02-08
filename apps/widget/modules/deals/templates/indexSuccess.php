<div class="whtboxtop">
	<div class="rcor">
		<h1 class="deal-title"><?php echo __('Recent Deals'); ?> <em><?php echo __('(Coupons that have run out, are deleted from this list automatically)'); ?></em></h1>
	</div>
</div>
<div class="wht-contentbox clearfix">
	<div class="popwidecol alignright" id="coupon-used-box">

	<?php include_component('deals', 'coupon_used', array('pDealId' => '1')); ?>
  </div>

	<div class="alignleft picnavbox">
  	<ul class="prnav" id="show-deal-list">
     	<li><img src="/img/lamp-icon.gif" width="12" height="14" alt="pics.nase-bohren.de" title="pics.nase-bohren.de" /><a href="<?php echo url_for('@get_coupon_used?dealid=1', array('dealid' => '1'));?>" class="active show-deal-link">pics.nase-bohren.de</a></li>
      <li><img src="/img/dozen-icon.gif" width="13" height="15" alt="Dozenten-Scout" title="Dozenten-Scout" /> <a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">Dozenten-Scout</a></li>
      <li><img src="/img/ria-icon.jpg" width="13" height="14" alt="ripanti.com" title="ripanti.com" /><a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">ripanti.com</a></li>
      <li><img src="/img/ria-icon.jpg" width="13" height="14" alt="Brille24" title="Brille24" /><a href="<?php echo url_for('@get_coupon_used', array('dealid' => '1'));?>" class="show-deal-link">Brille24</a></li>
    </ul>
  </div>
</div>
<div class="whtboxbot"><span></span></div>