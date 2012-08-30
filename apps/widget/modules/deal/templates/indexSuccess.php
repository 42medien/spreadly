<?php
use_helper('Avatar', 'Text');
?>

<header>
	<h1 class="success"><?php echo __('Thanks for sharing!'); ?></h1>
	<span id="deal-marker"><?php echo __('Grab your deal!'); ?></span>
	<h2><?php echo $deal->getMotivationTitle(); ?><span id="motivation"><?php echo $deal->getMotivationText(); ?></span></h2>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">

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

  <form action="" name="popup-like-form" id="popup-like-form" class="deal-form" method="post">
    <div id="comment-area" class="clearfix deal-comment">
      <textarea id="area-like-comment" class="mirror-value bordered gradient shadow-wide" name="like[comment]" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #deal"></textarea>
      <span id="comment-area-counter-box"><span id="area-like-comment_counter">0</span> <?php echo __('Zeichen'); ?></span>
    </div>
    <div id="like-submit">
    	<?php include_component("like", "share_section"); ?>
    </div>
    <input type="hidden" name="like[d_id]" id="deal-img-value" value="<?php echo $deal->getId(); ?>" />
  </form>
</div>