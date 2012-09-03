<?php
use_helper('Avatar', 'Text');
?>

<div class="title">
  <h1><?php echo __("Your share &amp; bookmark was successful!"); ?></h1>
</div>
<div class="clear"></div>

<div class="red_bg_sh">
  <div class="red_bg">
    <div class="red_bg_custom">
      <div class="sh_img_block scrollable" id="myscroll">
        <div id="meta-images" class="imgbg items">
          <img id="meta-img" src="<?php echo $deal->getSpreadImg(); ?>" width="80" />
        </div>
      </div>
      <div class="sh_info">
        <h2 title="<?php echo $deal->getSpreadTitle(); ?>"><?php echo truncate_text($deal->getSpreadTitle(), 50); ?></h2>
        <p>
          <?php echo truncate_text($deal->getSpreadText(), 150); ?>
        </p>
        <p><a href="<?php echo $deal->getSpreadUrl(); ?>" target="_blank" title="<?php echo $deal->getSpreadUrl(); ?>">
        <?php echo truncate_text($deal->getSpreadUrl(), 50); ?></a></p>
      </div>
      <div class="clear"></div>
      <div class="pers_comments">
        <textarea id="texarea_count" rows="2" cols="20" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #like"></textarea>
        <div class="clear"></div>
        <span id="chars_counter">0</span>
      </div>
    </div>
  </div>
</div>

<form action="" name="popup-like-form" id="popup-like-form" class="deal-form" method="post">
<div class="sh_networks">
  <div class="gradient">
    <h1>Choose the networks you want to post to</h1>
    <?php include_component("like", "share_section", array('pError' => $pError)); ?>
    <input type="hidden" name="like[d_id]" id="deal-img-value" value="<?php echo $deal->getId(); ?>" />
    <div class="clear"></div>
  </div>
</div>
</form>