<div id="main_area" class="clearfix">
  <div id="main_area_navigation" class="clearfix">
    <ul class="clearfix">
      <li class="main_navigation" id="nav_headline"><?php echo __('Get your button!'); ?></li>
      <li class="main_navigation active" id="nav_choose_app"><a href="likebutton/get_choose_app" id="nav_element_choose_app">&raquo; <?php echo __('Step 1/2: Choose Type of Site'); ?></a></li>
      <li class="main_navigation active hide" id="nav_choose_style"><a href="/" id="nav_element_choose_style">&raquo; <?php echo __('Step 2/2: Choose Style'); ?></a></li>
    </ul>
  </div>

  <div id="main_area_content" class="clearfix">
    <?php include_component('likebutton', 'choose_app'); ?>
  </div>
</div>