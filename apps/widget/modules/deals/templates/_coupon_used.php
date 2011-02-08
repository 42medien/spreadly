<?php use_helper("Date"); ?>
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
     	<div class="grboxmid-content">
				<div class="graybox clearfix">
         	<div class="clearfix spactsbox">
           	<img src="/img/spacts.jpg" width="93" height="30" alt="Empfehlen Sie" title="Empfehlen Sie" class="spacatspic" /><span class="picmultiline"><?php echo $pDeal->getDomainProfile(); ?></span>
          </div>
          <div class="dotborboxsmall dotborboxmore">
          	<h2 class="graytitle txtcenter"><?php echo $pDeal->getDescription(); ?></h2>
            <div class="whtrow codebox">
    	       	<div class="rcor">
             		<span class="fs13"><?php echo __('Ihr Gutschein-Code:'); ?></span><br /><span class="code">XYZ123ABC456</span>
              </div>
            </div>
            <p class="exprebox"><?php echo __('Bitte bis zum %expire% einl&ouml;sen unter:', array('%expire%' => $pDeal->getEndDate())); ?></p>
          </div>
          <div class="htplinks"><a href="<?php echo url_for($pDeal->getRedeemUrl()); ?>"><?php echo $pDeal->getRedeemUrl(); ?></a></div>
				</div>
      </div>
    </div>
    <div class="grboxbot"><span></span></div>