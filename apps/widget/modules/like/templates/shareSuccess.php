<?php use_helper('Avatar', 'Text'); ?>


<div class="title">
  <h1><?php echo __("Share a page"); ?></h1>
</div>
<div class="clear"></div>

<form method="GET" name="share-form">
<div class="sh_content">
  <div class="sh_info">
    <h2><?php echo __("Copy the link you want to share into the input-box below and hit the share-button"); ?></h2>
    <input type="url" name="url" placeholder="http://example.com/" required="required" class="share-url" value="<?php echo $url ?>" />
  </div>
</div>

<div class="clear"></div>

<div class="sh_networks">
  <div class="gradient">
    <div class="sh_networks_content">
      <div class="sharebtn-active">
        <div class="sharebtn_graphic">
          <input type="submit" value="<?php echo __("share this link"); ?>" />
          <span></span>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>

</form>