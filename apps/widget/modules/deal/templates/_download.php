<div class="voucher_text">
  <p><?php echo __("THANK YOU FOR SPREADING THE WORD! here's YOUR PROMISED VOUCHER ASCENTIVE:"); ?></p>
</div>
<div class="voucher">
    <div class="voucher_brd">
        <div class="voucher_data">
            <p class="percent"><?php echo $deal->getCouponTitle(); ?></p>
            <p class="song"><?php echo $deal->getCouponText(); ?></p>
            <div class="btn">
                <span>
                    <a href="<?php echo $deal->getCouponUrl(); ?>" target="_blank"><?php echo __("Download"); ?></a>
                </span>
            </div>                   
        </div>
    </div>                   
</div>