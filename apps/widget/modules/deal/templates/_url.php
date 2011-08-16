<h4><?php echo $deal->getCouponTitle(); ?></h4>

<p class="text"><?php echo $deal->getCouponText(); ?></p>

<div class="url"><a href="<?php echo $deal->getCouponUrl(); ?>"><?php echo __("Visit") . " " . parse_url($deal->getCouponUrl(), PHP_URL_HOST); ?> &rarr;</a></div>