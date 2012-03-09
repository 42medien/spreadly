<?php use_helper('Text'); ?>

          <nav>
            <!-- Navi rechte Seite -->
            <ul class="nav-list" role="navigation">
              <?php if ($sf_user->isAuthenticated()) { ?>
              <li><span title="<?php echo $sf_user->getUser()->getUsername(); ?>" id="nav-username"><?php echo __('Hi'); ?> <a id="edit-settings-link" href="<?php echo url_for('@widget_settings'); ?>"><?php echo truncate_text($sf_user->getUser()->getUsername(), 10); ?></a></span></li>
              <!-- li><?php echo link_to(__('Likes'), '@widget_likes'); ?></li>
              <li><?php echo link_to(__('Deals'), '@widget_deals'); ?></li-->
              <li><?php echo link_to(__('Logout'), '@signout'); ?></li>
              <?php } ?>
              <li><?php echo link_to(__("Imprint"), "http://spreadly.com/imprint", array("target" => "_blank")); ?></li>
              <li><?php echo link_to("Powered by Spreadly", sfConfig::get("app_settings_url"), array("title" => "spreadly", "target" => "_blank")) ?></li>
            </ul>
          </nav>