<?php use_helper("Date"); ?>

<?php //include_partial('like/coupon_unused', array('pDeal' => $pActiveDeal, 'pUrl' => $pUrl, 'pTags' => $pTags)); ?>

<form action="<?php echo url_for('@save_like'); ?> " name="popup-deal-form" id="popup-deal-form" method="post">

    <input type="hidden" name="like[url]" value="<?php echo $pUrl; ?>" />
    <input type="hidden" name="like[tags]" value="<?php echo $pTags; ?>" />

    <div class="whtboxtopwide spreadsel_box">
      <div class="rcor clearfix">
        <div class="alignleft checklist">
          <ul class="clearfix">
            <?php foreach($pIdentities as $lIdentity) {?>
            <li>
              <label><input type="checkbox" name="like[oiids][]" value="<?php echo $lIdentity->getId(); ?>" <?php if ($lIdentity->getSocialPublishingEnabled()) { echo "checked='checked'"; }  ?> /></label><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getCommunity()->getName(), "title" => $lIdentity->getCommunity()->getName())); ?>
            </li>
            <?php } ?>
          </ul>
        </div>
      </div>
    </div>
    <div class="wht-contentbox clearfix">
			<div class="popwidecol" id="coupon-unused-container">
		  	<div class="grboxtop"><span></span></div>
		    <div class="grboxmid">
		    	<div class="grboxmid-content">
						<div class="graybox clearfix rempvepad">
		    			<div class="clearfix spactsbox" id="coupon-head-summary">
		      			<span><?php echo __('Empfehlen Sie "%link%" und erhalten Sie ...', array('%link%' => link_to($pActiveDeal->getSummary(), '/'))); ?></span>
		      		</div>
		          <div class="dotborbox">
		          	<h2 class="graytitle"><?php echo $pActiveDeal->getSummary(); ?></h2>
		            <div class="whtrow">
		            	<div class="rcor"><?php echo $pActiveDeal->getDescription(); ?></div>
		            </div>
		            <p class="exprebox">87/100 Deals left</p>
		          </div>
		          <div class="dieblock">
		<!--<a class="graybtn alignright" title="Copy code" href="#"><span><em class="pleasemeicon">Gefallt mir</em></span></a> -->
		          	<span class="alignleft ekrenne"><label class="radio-btn"> <input type="checkbox" name="like[tos]" /></label>Ich erkenne die <span class="txt-blue">Teilnahmebedingungen</span> an.</span>
		          	<span class="alignmiddle btn" id="popup-send-deal-box"><input type="submit" id="popup-send-deal-button" value="Spread It" /></span>
		          </div>
						</div>
		      </div>
		    </div>
		    <div class="grboxbot"><span></span></div>
		  </div>
    </div>
</form>
