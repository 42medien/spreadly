<div class="three_quarter left">
  <ul class="yiidit_app_icons area_border clearfix" id="services_area">
    <?php foreach($pServices as $lService) { ?>
        <?php if($lService->getDownloadUrl()) { ?>
        <li>
		      <div class="yiidit_app_icon clearfix">
		        <a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank" id="<?php echo $lService->getSlug(); ?>_icon">&nbsp;</a>
		      </div>
		      <div class="clearfix">
		        <a href="<?php echo $lService->getDownloadUrl(); ?>" target="_blank"><?php echo $lService->getName(); ?></a>
		      </div>
		    </li>
		    <?php } elseif ($lService->getTutorialUrl()) { ?>
		    <li>
          <div class="yiidit_app_icon clearfix">
            <a href="/likebutton/get_choose_style?service=<?php echo $lService->getId();?>" class="config-app-link" id="<?php echo $lService->getSlug(); ?>_icon">&nbsp;</a>
          </div>
          <div class="clearfix">
            <a href="/likebutton/get_choose_style?service=<?php echo $lService->getId();?>" class="config-app-link" ><?php echo $lService->getName(); ?></a>
          </div>
          </li>
		    <?php } ?>
    <?php } ?>
  </ul>
</div>

<div class="one_quarter left">
  <ul class="yiidit_app_icons area_border clearfix" id="any_website_area">
    <li>
      <div class="yiidit_app_icon clearfix">
        <a href="/likebutton/get_choose_style" class="choose_any_website config-app-link" id="anywebsite_icon">&nbsp;</a>
      </div>
      <div class="clearfix">
        <a href="/likebutton/get_choose_style" class="choose_any_website config-app-link"><?php echo __('Other Website'); ?></a>
      </div>
    </li>
    <li>
      <div class="yiidit_app_icon clearfix">
        <a href="/likebutton/get_choose_email_signatures" class="choose_email config-app-link" id="email_icon">&nbsp;</a>
      </div>
      <div class="clearfix">
        <a href="/likebutton/get_choose_email_signatures" class="choose_email config-app-link"><?php echo __('Email &amp; Signatures'); ?></a>
      </div>
    </li>
  </ul>
</div>