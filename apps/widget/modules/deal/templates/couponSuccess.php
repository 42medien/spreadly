<?php
use_helper('Avatar', 'Text');
?>
<h1 class="title"><?php echo __("Your share was successful!"); ?></h1>
<div class="clear"></div>
<div class="red_bg_sh">
  <div class="red_bg">
    <div class="red_cont">
      <?php include_partial($deal->getCouponType(), array('deal' => $deal)); ?>
      <div class="blue_btn">
        <?php echo link_to(__("get another deal"),  "deal/index", array("query_string" => "url=")); ?>
      </div>
    </div>
  </div>
</div>