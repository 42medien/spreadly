<div class="voucher_text">
  <p>
    <?php echo __("Thank you for spreading the word!"); ?><br />
    <?php echo __("here's your promised voucher code:"); ?>
  </p>
</div>
<div class="voucher">
  <div class="voucher_brd">
    <div class="voucher_data">
      <p class="offer"><?php echo $deal->getCouponTitle(); ?></p>
      <a href="<?php echo $deal->getCouponRedeemUrl(); ?>" target="_blank"><?php echo __("Visit the shop"); ?></a>
      <div class="v_code">
        <input type="text" value="<?php echo $sf_request->getParameter("u_code", "error"); ?>" />
        <div class="btn">
          <span>
            <span>copy code</span>
          </span>
        </div>
        <div class="clear"></div>
      </div>
      <p class="bt_text"><?php echo $deal->getCouponText(); ?></p>
    </div>
  </div>
</div>