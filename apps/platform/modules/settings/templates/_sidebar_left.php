<?php use_helper('Text', 'Avatar'); ?>
<?php $lUser = $sf_user->getUser(); ?>
<div id="photo_filter_box" class="bg_light bd_diagonal bd_normal_light clearfix">

  <div class="photo_big" id="stream_photo">
    <?php echo avatar_tag($lUser->getDefaultAvatar(), 140, array('alt' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
  </div>
<!-- filter_headline_communities_active  -->
  <p class="filter_headline filter_headline_active clearfix">
    <?php echo link_to(__('SETTINGS'), 'settings/index'); ?>
    <span class="right filter_chosen_icon">&nbsp;</span>
  </p>
  <ul class="normal_list clearfix">
    <li>
    </li>
  </ul>
</div>