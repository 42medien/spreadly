<?php use_helper('Date', 'YiidUrl', 'Avatar') ?>

<?php foreach($pDislikes as $lDislike) { ?>
  <?php $lUser = $lDislike->getUser(); ?>
    <li class="clearfix vcard">
      <div class="stream-avatar">
        <a class="dis-act-user-img url" href="<?php echo url_for_yiid($lUser->getUsername()); ?>" rel="contact" title="<?php echo $lUser->getUsername(); ?>">
          <?php echo avatar_tag($lUser->getDefaultAvatar(),30,array('alt' => $lUser->getFullname(), 'class' => 'fn photo', 'rel' => 'contact')); ?>
        </a>
      </div>
      <div class="stream-entry">
        <?php echo __('ACTIVITY_DISLIKE', array('%1' => link_to_yiid($lDislike->getUser()->getUsername(), $lUser->getUsername(),null, array('class' => 'stream-link')), '%2' => link_to($lDislike->getUrl(), $lDislike->getUrl(), array('class' => 'stream-link', 'target' => '_blank')))); ?>
        <div class="single-entry-info arrow-grey">
          <?php echo __('USERS_DONT_LIKE', array('%1' => $lDislike->getDislikeCount()-1)); ?>
        </div>
      </div>
      <div class="unlike-button">
        <?php include_partial('widget/sample_button', array('pUrl' => $lDislike->getUrl(), 'pBgColor'=>'#ffffff', 'pFontColor' => '#000000')); ?>
      </div>
    </li>
<?php } ?>