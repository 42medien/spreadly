<?php use_helper('Text'); ?>


<div class="footer_line">
  <div class="footer_shadow"></div>
    <span class="left">
      <?php if ($sf_user->isAuthenticated()) { ?>
      <span title="<?php echo $sf_user->getUser()->getUsername(); ?>" id="nav-username"><?php echo __('Hi'); ?> <?php echo truncate_text($sf_user->getUser()->getUsername(), 10); ?></span> |
      <!-- li><?php echo link_to(__('Likes'), '@widget_likes'); ?></li>
      <li><?php echo link_to(__('Deals'), '@widget_deals'); ?></li-->
      <?php echo link_to(__('Logout'), '@signout'); ?>
      <?php } ?>
    </span>
    <span class="right">
      <?php echo link_to("Powered by Spreadly", sfConfig::get("app_settings_url"), array("title" => "spreadly", "target" => "_blank")) ?> |
      <?php echo link_to(__("Imprint"), "http://spreadly.com/imprint", array("target" => "_blank")); ?>
    </span>
  <div class="clear"></div>
</div>