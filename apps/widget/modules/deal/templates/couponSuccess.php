<?php
use_helper('Avatar', 'Text');
?>
<header>
  <h1 class="success"><?php echo __("Thanks for sharing!"); ?></h1>
 <span id="deal-marker"><?php echo __("Your deal"); ?></span>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
  <?php include_partial($deal->getCouponType(), array('deal' => $deal)); ?>
</div>