<?php use_helper('Avatar', 'Text'); ?>
<?php
$lImages = $pYiidMeta->getImages();
if ($lImages && count($lImages) > 0) {
  $lImage = $lImages[0];
} else {
  $lImage = "";
}
?>

<div id="comment-area" class="clearfix">
	<textarea id="area-like-comment" class="mirror-value bordered gradient shadow-wide" name="like[comment]" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #like"></textarea>
</div>

<div class="clearfix">
	<p class="area-like-comment-mirror"></p>
	<div id="like-select-img" class="alignleft">
		<div class="scrollable bordered-light shadow-light" id="myscroll">
	  	<!-- root element for the items -->
	    <div class="items alignleft" id="scroll-meta-images">
	    	<?php include_partial('like/meta_images_list', array('pImages' => $lImages)); ?>
	  	</div>
		</div>
		<div class="gallery-control clearfix">
	  	<div id="scroll-button-area" class="clearfix" <?php echo (count($pYiidMeta->getImages()) <= 1)? "style='display:none;'":"";?>>
	    	<a class="prev browse alignleft slide-back-link" id="slide-back-link"></a>
	      <a class="next browse alignright slide-next-link" id="slide-next-link"></a>
	  	</div>
		</div>
	</div>
	<div class="alignleft clearfix" id="like-content">
		<h4 title="<?php echo $pYiidMeta->getTitle(); ?>">
	  <?php echo truncate_text($pYiidMeta->getTitle(), 50); ?>
	  </h4>
	  <p>
	  	<?php echo truncate_text($pYiidMeta->getDescription(), 150); ?>
	  </p>
	  <p title="<?php echo $pYiidMeta->getUrl(); ?>">
	  	<?php echo truncate_text($pYiidMeta->getUrl(), 50); ?>
	  </p>
	</div>
</div>

<div id="like-submit">
		<div id="like-response"></div>
		<?php if (!$sf_user->isAuthenticated() ) { ?>
			<h4><?php echo __('Please choose your favorite service for sharing.'); ?> <?php echo __('You can add additional services anytime later.'); ?></h4>
		<?php } ?>
		<a class="send B" href="#" onclick="document.forms['popup-like-form'].submit();return false;">Continue and Share</a>
		<?php if ($sf_user->isAuthenticated() ) { ?>
		<ul class="clearfix" id="like-oi-list">
	  	<?php foreach($pIdentities as $lIdentity) {?>
	    	<li class="B">
					<input type="checkbox" id="o<?php echo $lIdentity->getId(); ?>" name="like[oiids][]" value="<?php echo $lIdentity->getId(); ?>" <?php if ($lIdentity->getSocialPublishingEnabled()) { echo 'checked="checked"'; }  ?> />
					<label for="o<?php echo $lIdentity->getId(); ?>"><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getName(), "title" => $lIdentity->getName())); ?></label>
	      </li>
	  	<?php } ?>
	  		<li class="B">
          <a href="#">+add</a>
        </li>
	  </ul>
	  <?php } else { ?>
	  <ul class="clearfix" id="like-oi-list">
	  	<li class="B" id="o1" onclick="window.open('<?php echo url_for("@signinto?service=twitter"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;">
	  	  <input class="add-service-checkbox" type="checkbox" name="twitter" value="twitter" />
	  	  <label for="o1"><?php echo link_to(image_tag("/img/twitter-favicon.gif", array("alt" => 'Twitter', "title" => 'Twitter')), "@signinto?service=twitter"); ?></label>
	  	</li>
	  	<li class="B" id="o2" onclick="window.open('<?php echo url_for("@signinto?service=facebook"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;">
	  	  <input class="add-service-checkbox" type="checkbox" name="facebook" value="facebook" />
	  	  <label for="o2"><?php echo link_to(image_tag("/img/facebook-favicon.gif", array("alt" => 'facebook', "title" => 'facebook')), "@signinto?service=facebook"); ?></label>
	  	</li>
	  	<li class="B" id="o3" onclick="window.open('<?php echo url_for("@signinto?service=linkedin"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;">
	  	  <input class="add-service-checkbox" type="checkbox" name="linkedin" value="linkedin" />
	  	  <label for="o3"><?php echo link_to(image_tag("/img/linkedin-favicon.gif", array("alt" => 'Linkedin', "title" => 'Linkedin')), "@signinto?service=linkedin"); ?></label>
	  	</li>
	  	<li class="B" id="o4" onclick="window.open('<?php echo url_for("@signinto?service=google"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;">
	  	  <input class="add-service-checkbox" type="checkbox" name="google" value="google" />
	  	  <label for="o4"><?php echo link_to(image_tag("/img/google-favicon.gif", array("alt" => 'google', "title" => 'google')), "@signinto?service=google&r=s"); ?></label>
	  	</li>
		</ul>
	  <?php } ?>
</div>

<input type="hidden" name="like[thumb]" id="like-img-value" value="<?php echo $lImage; ?>" />
<input type="hidden" name="like[title]" value="<?php echo htmlspecialchars($pYiidMeta->getTitle()); ?>" />
<input type="hidden" name="like[descr]" value="<?php echo htmlspecialchars($pYiidMeta->getDescription()); ?>" />
<input type="hidden" name="like[url]" value="<?php echo $pYiidMeta->getUrl(); ?>" />
<input type="hidden" name="like[tags]" value="<?php echo $sf_request->getParameter('tags'); ?>" />
<input type="hidden" name="like[clickback]" value="<?php echo $sf_request->getParameter('clickback'); ?>" />