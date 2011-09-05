<div id="deal_coupon">
  <h3><?php echo $deal->getCouponTitle(); ?></h3>
  <span id="redeemcode"><?php echo $deal->getCouponCode(); ?></span>

  <a class="link B" href="index.html">Copy to clipboard</a>
  <p><?php echo $deal->getCouponText(); ?></p>
</div>