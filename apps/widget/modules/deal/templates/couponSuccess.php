<?php
use_helper('Avatar', 'Text');
?>
<header>
  <h2><?php echo __("Thanks for sharing!"); ?></h2>
  <p id="motivation">
    <span id="deal-marker">Your deal</span>
  </p>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
  <?php include_partial($deal->getCouponType(), array('deal' => $deal)); ?>
</div>