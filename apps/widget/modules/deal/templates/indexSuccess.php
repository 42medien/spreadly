<?php
use_helper('Avatar', 'Text');
?>
<header>
  <h2>Share this page<span>$documenttitle ipsumy nibh euismod tincidunttincidunttincidunt ut laoreet dolore magna aliquam erat volutpat.</span></h2>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">
  <h3><?php echo $deal->getMotivationTitle(); ?></h3>
  <h4><?php echo $deal->getMotivationText(); ?></h4>

  <form action="" name="popup-like-form" id="popup-like-form" method="post">
    <div class="clearfix">
      <p class="area-like-comment-mirror"></p>
      <div id="like-select-img" class="alignleft">
        <div class="scrollable bordered-light shadow-light" id="myscroll">
          <!-- root element for the items -->
          <div class="items alignleft" id="scroll-meta-images">
            <img id="meta-img" src="<?php echo $deal->getSpreadImg(); ?>" width="80" />
          </div>
        </div>
      </div>
      <div class="alignleft clearfix" id="like-content">
        <h4 title="<?php echo $deal->getSpreadTitle(); ?>">
        <?php echo truncate_text($deal->getSpreadTitle(), 50); ?>
        </h4>
        <p>
          <?php echo truncate_text($deal->getSpreadText(), 150); ?>
        </p>
        <p title="<?php echo $deal->getSpreadUrl(); ?>">
          <?php echo truncate_text($deal->getSpreadUrl(), 50); ?>
        </p>
      </div>
    </div>

    <div id="comment-area" class="clearfix deal-comment">
      <textarea id="area-like-comment" class="mirror-value bordered gradient shadow-wide" name="like[comment]" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #deal"></textarea>
    </div>

    <?php include_component("like", "share_section"); ?>

    <input type="hidden" name="like[d_id]" id="deal-img-value" value="<?php echo $deal->getId(); ?>" />
  </form>
</div>