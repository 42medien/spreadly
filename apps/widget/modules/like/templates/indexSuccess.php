<?php use_helper('Avatar', 'Text'); ?>

<header>
  <h2>Share this page<span>$documenttitle ipsumy nibh euismod tincidunttincidunttincidunt ut laoreet dolore magna aliquam erat volutpat.</span></h2>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix">
  <form action="<?php echo url_for('@save_like'); ?> " name="popup-like-form" id="popup-like-form" method="post">
    <?php include_partial('like/like_content', array('pYiidMeta' => $pYiidMeta, 'pIdentities' => $pIdentities))?>
  </form>
</div>