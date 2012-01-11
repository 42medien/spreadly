<?php use_helper('Avatar', 'Text'); ?>

<header>
  <h2><?php echo __("Share a page"); ?><span><?php echo __("What do you want to share today?"); ?></span></h2>
</header>

<!-- weisser Content -->
<div id="content-inner" class="clearfix">
  <p class="share-teaser"><?php echo __("Copy the link you want to share into the input-box below and hit the share-button"); ?></p>

  <form method="GET" name="share-form">
    <input type="url" name="url" placeholder="http://example.com/" required="required" class="share-url" value="<?php echo $url ?>" />
    <div class="error"><?php echo $error ?></div>

    <a class="send B share-button" id="logoutbutton" onclick="document.forms['share-form'].submit();return false;" href="#"><?php echo __("Share this page"); ?></a>
  </form>
</div>