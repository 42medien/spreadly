<?php
use_helper('Avatar', 'Text');
?>
<div id="content-outer" class="clearfix" role="main">
<header>
	<h1 class="success"><?php echo __('Thanks for sharing!'); ?></h1>
	<span id="deal-marker"><?php echo __('Grab your deal!'); ?></span>
	<h2><?php echo $pDeal->getMotivationTitle(); ?><span id="motivation"><?php echo $pDeal->getMotivationText(); ?></span></h2>
</header>


<!-- weisser Content -->
<div id="content-inner" class="clearfix deal-content-inner">

    <div class="clearfix">
      <div id="like-select-img" class="alignleft">
        <div class="scrollable bordered-light shadow-light" id="myscroll">
          <!-- root element for the items -->
          <div class="items alignleft" id="scroll-meta-images">
            <img id="meta-img" src="<?php echo $pDeal->getSpreadImg(); ?>" width="80" />
          </div>
        </div>
      </div>
      <div class="alignleft clearfix" id="like-content">
        <h4 title="<?php echo $pDeal->getSpreadTitle(); ?>">
        <?php echo truncate_text($pDeal->getSpreadTitle(), 50); ?>
        </h4>
        <p>
          <?php echo truncate_text($pDeal->getSpreadText(), 150); ?>
        </p>
        <p title="<?php echo $pDeal->getSpreadUrl(); ?>">
          <?php echo truncate_text($pDeal->getSpreadUrl(), 50); ?>
        </p>
      </div>
    </div>


		<div id="popup-like-form">
	    <div id="comment-area" class="clearfix deal-comment">
	      <textarea id="area-like-comment" class="mirror-value bordered gradient shadow-wide" name="area-like-comment" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #deal"></textarea>
	    </div>
	        <div id="like-response"></div>
	    <div id="like-submit" class="clearfix">
	        <ul class="clearfix" id="like-oi-list">
	          <li class="B" id="o1">
	            <input class="add-service-checkbox" type="checkbox" name="twitter" value="twitter" checked="true"/>
	            <label for="o1"><?php echo link_to(image_tag("/img/twitter-favicon.gif", array("alt" => 'Twitter', "title" => 'Twitter')), "/deals/step_verify?did=".$pDeal->getId()); ?></label>
	          </li>
	          <li class="B" id="o2">
	            <input class="add-service-checkbox" type="checkbox" name="facebook" value="facebook" checked="true"/>
	            <label for="o2"><?php echo link_to(image_tag("/img/facebook-favicon.gif", array("alt" => 'facebook', "title" => 'facebook')), "/deals/step_verify?did=".$pDeal->getId()); ?></label>
	          </li>
	          <li class="B" id="o3">
	            <input class="add-service-checkbox" type="checkbox" name="linkedin" value="linkedin" checked="true" />
	            <label for="o3"><?php echo link_to(image_tag("/img/linkedin-favicon.gif", array("alt" => 'Linkedin', "title" => 'Linkedin')), "/deals/step_verify?did=".$pDeal->getId()); ?></label>
	          </li>
	          <li class="B" id="o4">
	            <input class="add-service-checkbox" type="checkbox" name="google" value="google" checked="true" />
	            <label for="o4"><?php echo link_to(image_tag("/img/google-favicon.gif", array("alt" => 'google', "title" => 'google')), "/deals/step_verify?did=".$pDeal->getId()); ?></label>
	          </li>
	        </ul>
	        <a id="popup-like-button" class="send B" href="#">Continue and Share</a>
	       </div>
     	</div>
</div>
</div>