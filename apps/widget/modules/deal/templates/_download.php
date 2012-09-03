<div class="voucher_text">
  <p>
    <?php echo __("Thank you for spreading the word!"); ?><br />
    <?php echo __("here's your promised incentive:"); ?>
  </p>
</div>
<div class="voucher">
  <div class="voucher_brd">
    <div class="voucher_data">
      <p class="offer"><?php echo $deal->getCouponTitle(); ?></p>
      <p class="song"><?php echo $deal->getCouponText(); ?></p>
      <div class="btn">
        <span>
          <span><a class="link" href="<?php echo $deal->getCouponUrl(); ?>" target="_blank"><?php echo __("Download"); ?></a></span>
        </span>
      </div>                   
    </div>
  </div>                   
</div>