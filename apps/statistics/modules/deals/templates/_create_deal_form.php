<?php

	/**
	 * To check, if we are in the edit-mode
	 * if so, set edit to true (need for checks inside of the form) and get the deal bound to the form
	 */
	$lIsEdit = false;
	$lDeal = null;
	if($pForm->getEmbeddedForm('deal')->getObject()->getId()){
		$lIsEdit = true;
		$lDeal = $pForm->getEmbeddedForm('deal')->getObject();
	}

	/**
	 * if the form is bound means: if it is validated. if it is, we get the default values from the validated form object to display
	 * if not, we display the "normal" defaults
	 */
	if($pForm->isBound()){
		$lDealValues = $pForm->getTaintedValues();
		$lDefaultDeal = $lDealValues['deal'];
	} else {
		$lDefaultDeal =  $pForm->getEmbeddedForm('deal')->getDefaults();
	}

?>


<form action="" method="post" id="deal_form" name="deal_form">
	<?php echo $pForm['deal']['id']->render();?>
	<?php echo $pForm['_csrf_token']->render(); ?>
<div class="grboxtop"><span></span></div>
<div class="grboxmid">
	<div class="grboxmid-content">


<!-- ********** Select domain area ********** -->
		<div class="graybox clearfix nopadlr">
    	<div class="container_12 cndisplay">
      	<div class="clearfix">
        	<span class="alignleft discblock"><img src="/img/discount-pic.png" width="48" height="48" alt="Spread" title="Spread" /></span>
					<div class="deaelouterblock alignright">
						<div class="newdeal clearfix">
            	<span class="alignleft deal-titlebc"><?php if($lIsEdit) { ?><?php echo __('Edit Deal')?><?php } else { ?><?php echo __('Create New Deal')?><?php } ?></span>
              <label id="websellist" class="alignleft">
              <?php if($lIsEdit) { ?>
								<select id="id" class="custom-select" name="id" style="display: none;">
									<option value="<?php echo $pFirstDomain->getId(); ?>"><?php echo $pFirstDomain->getUrl(); ?></option>
								</select>
              <?php } else { ?>
              	<?php echo $pForm['id']->render(array('class' => "custom-select"));?>
              <?php } ?>
              </label>
            </div>
            <?php if($lIsEdit) { ?>
							<p><?php echo __('Button wording, deal description, scheduling and quantity fields are pre-populated with your existing deal settings. Edits you make here will replace your existing deal. Once you submit your changes, your deal will stop running until it has been approved by our team.'); ?></p>
            <?php } else { ?>
            	<p><?php echo __('Push your content into social networks through recommendations. Only one deal per domain at a time. Please allow 24 hours for reviewing new or changed deals.'); ?></p>
            <?php }?>
          </div>
        </div>



<!-- ********** Create button area ********** -->
        <div class="grid_12">
        	<div class="popoboxpad">
          	<div class="grboxtop"><span></span></div>
            <div class="grboxmid">
            	<div class="grboxmid-content">
              	<div class="graybox clearfix">
                	<div class="likenbox alignright">
                  	<span class="gefelink"><a href="#"><img src="/img/gefeatmir.png" width="89" height="32" alt="Gefallt mir" title="Gefallt mir" /></a><span class="deal_button_wording-mirror"><?php echo __('...and win a free trial membership for one month!'); ?></span></span>
                  </div>
                  <div class="createbtnbox alignleft">
                  	<h2 class="btntitle"><span>1</span><?php echo __('Create your Button')?></h2>
                    <ul class="btnformlist">
                    	<li class="clearfix last" >
                      	<div class="btnwording alignleft"><strong><?php echo $pForm['deal']['button_wording']->renderLabel();?></strong> <span><?php echo __('<span id="button_wording_counter">35</span> characters left'); ?></span></div>
                      	<label class="textfield-wht"><span><?php echo $pForm['deal']['button_wording']->render(array('class' => 'mirror-value wd390'));?></span></label>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['button_wording']->renderError();?></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
	          <div class="grboxbot"><span></span></div>
          </div>

<!-- ********** Configure coupon area ********** -->
          <div class="popoboxpad">
          	<div class="grboxtop"><span></span></div>
            <div class="grboxmid">
            	<div class="grboxmid-content">
              	<div class="graybox clearfix">
                	<div class="dealwidebox alignright">
                  	<div>
                    	<div class="dotborbox">
                      	<h2 class="graytitle textcenter deal_summary-mirror"><?php echo $lDefaultDeal['summary']; ?></h2>
                        <div class="whtrow">
                        	<div class="rcor deal_description-mirror"><?php echo $lDefaultDeal['description']; ?></div>
                        </div>
                        <p class="exprebox"><?php echo __('Expires at'); ?> <span id="deal_end_date-mirror"><?php echo $lDefaultDeal['end_date']; ?></span>  | 87/100 left</p>
                      </div>
                      <div class="dieblock clearfix">
                      	<span class="alignleft ekrenne">
                      		<span class="checkboxwht">
                      			<label class="radio-btn"> <input type="checkbox" name="" /></label>
                      		</span><?php echo __('I accept the %terms%', array('%terms%' => link_to(__('OFFER_TERMS_OF_DEAL'), '/'))); ?>
                      	</span>
                      </div>
                      <div class="txtcenter implink">
                      	<a href="#"><img src="/img/gefeatmir.png" width="89" height="32" alt="Gefallt mir" title="Gefallt mir" /></a>
                      </div>
                    </div>
                  </div>


                  <div class="createbtnbox alignleft">
                  	<h2 class="btntitle"><span>2</span><?php echo __('Configure your Coupon')?></h2>
                    <ul class="btnformlist">
                    	<li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong><?php echo $pForm['deal']['summary']->renderLabel();?></strong><span><?php echo __('<span id="summary_counter">40</span> characters left'); ?></span>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['summary']->render(array('class' => 'mirror-value wd390'));?>
                      		</span>
                      	</label>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['summary']->renderError();?></div>
                      </li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong><?php echo $pForm['deal']['description']->renderLabel();?></strong> <span><?php echo __('<span id="description_counter">80</span> characters left'); ?></span>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['description']->render(array('class' => 'mirror-value wd390'));?>
                      		</span>
                      	</label>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['description']->renderError();?></div>
                      </li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong class="singleline"><?php echo $pForm['deal']['start_date']->renderLabel();?></strong>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['start_date']->render(array("class" => "wd120"));?>
                      		</span>
                      	</label> <span class="deshline alignleft">-</span>
                      	<label class="textfield-wht">
                      		<span>
														<?php echo $pForm['deal']['end_date']->render(array("class" => "wd120"));?>
                      		</span>
                      	</label>
                      	<span class="requirrow alignleft"><?php echo __('(One active deal per domain at a time!)'); ?></span>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['end_date']->renderError();?><?php echo $pForm['deal']['start_date']->renderError();?></div>
                      </li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong><?php echo $pForm['deal']['terms_of_deal']->renderLabel();?></strong>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['terms_of_deal']->render(array('class' => 'wd320'));?>
                      		</span>
                      	</label><span class="requirrow alignleft"><?php echo __('(required)'); ?></span>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['terms_of_deal']->renderError();?></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="grboxbot"><span></span></div>
          </div>

<!-- ********** Configure success coupon area ********** -->
					<div class="popoboxpad">
          	<div class="grboxtop"><span></span></div>
            <div class="grboxmid">
            	<div class="grboxmid-content">
              	<div class="graybox clearfix">
                	<div class="dealsmallbox alignright">
                  	<div>
                    	<div class="dotborboxsmall dotborboxmore">
                      	<h2 class="graytitle txtcenter deal_summary-mirror"><?php echo $lDefaultDeal['summary']; ?></h2>
                        <div class="whtrow codebox">
                        	<div class="rcor">
                        		<span class="fs13"><?php echo __('Your Code:'); ?></span><br /><span class="code deal_coupon_single_code-mirror"><?php echo $pDefaultCode; ?></span>
                        	</div>
                        </div>
                        <p class="exprebox"><?php echo __('Expires at'); ?> <?php echo $lDefaultDeal['end_date']; ?></p>
                      </div>
                      <div class="htplinks"><a href="/" class="deal_redeem_url-mirror"><?php echo $lDefaultDeal['redeem_url']; ?></a></div>
                    </div>
                  </div>




                  <div class="createbtnbox alignleft">
                  	<h2 class="btntitle"><span>3</span><?php echo __('Configure your Coupon after a Like')?></h2>
                    <ul class="btnformlist">

	    								<?php if($lIsEdit) { ?>
	                    	<li class="clearfix">
	                      	<div class="btnwording alignleft">
	                      		<strong><?php echo __('Coupon-Codes');?></strong>
	                      	</div>
	                      	<label>
	                      		<span>
	                      			<?php echo __('You have chosen %codetype% for all deals:', array('%codetype%' => $pCouponType)); ?> <strong><?php echo $pDefaultCode; ?></strong>
	                      			<input type="hidden" name="deal[coupon_type]" value="<?php echo $pCouponType;?>" />
	                      		</span>
	                      	</label>
	                      </li>
	                    <?php } else { ?>
	                      <li class="clearfix">
	                      	<div class="btnwording alignleft">
	                      		<strong><?php echo $pForm['deal']['coupon_type']->renderLabel();?></strong><span><?php echo $pForm['deal']['coupon_type']->renderError();?></span>
	                      	</div>
	                      		<span>
	                      			<?php echo $pForm['deal']['coupon_type']->render();?>
	                      		</span>
	                      </li>
	                    <?php } ?>


											<!-- ********** Configure single code ********** -->
											<li id="single-code-row" <?php echo ($pCouponType == 'multiple')? 'style="display:none;"': ''; ?>>
											<ul>
											<?php if($lIsEdit) { ?>
												<li class="clearfix" <?php echo ($pCouponType == 'multiple')? 'style="display:none;"': ''; ?>>
													<input type="hidden" name="deal[coupon][single_code]" value="<?php echo $pDefaultCode; ?>" />
	                      	<div class="btnwording alignleft">
	                      		<strong><?php echo $pForm['deal']['coupon_quantity']->renderLabel();?></strong><span><?php echo $pForm['deal']['coupon_quantity']->renderError();?></span>
	                      	</div>
														<?php if($lDeal->isUnlimited()) {?>
	                      			<label>
																<span>
																	<?php echo __('Your coupon quantity is unlimited.'); ?>
																</span>
															</label>
														<?php } else { ?>
															<label class="textfield-wht">
																<span><?php echo __('Will end after');?> <?php echo $pForm['deal']['coupon_quantity']->render(array('class' => "wd15"));?></span>
															</label> <span class="requirrow alignleft"><?php echo __('likes'); ?></span>
														<?php } ?>
													</li>
											<?php } else { ?>
	                      <li class="clearfix">
	                      	<div class="btnwording alignleft">
	                      		<strong><?php echo $pForm['deal']['coupon']['single_code']->renderLabel();?></strong>
	                      	</div>
	                      	<label class="textfield-wht">
	                      		<span>
	                      			<?php echo $pForm['deal']['coupon']['single_code']->render(array('class' => 'wd320 mirror-value'));?>
	                      		</span>
	                      	</label><span class="requirrow alignleft"><?php echo __('(required)'); ?></span>
	                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['coupon']['single_code']->renderError();?></div>
	                      </li>

	                      <li class="clearfix">
	                      	<div class="btnwording alignleft" id="deal-quantity-label">
	                      		<strong><?php echo $pForm['deal']['coupon_quantity']->renderLabel();?></strong><span><?php echo $pForm['deal']['coupon_quantity']->renderError();?></span>
	                      	</div>
													<span class="onlyone alignleft"><input type="radio" name="single-quantity" id="radio-single-quantity" <?php echo ($pCouponQuantity > 0)? 'checked="checked"':''; ?> /><label id="radio-single-quantity-label"><?php echo __('Will end after');?></label></span><label class="textfield-wht"><span><?php echo $pForm['deal']['coupon_quantity']->render(array('class' => "wd15"));?></span></label> <span class="requirrow alignleft"><?php echo __('likes'); ?></span>

													<span class="onlyone alignright" id="quantitiy-unlimited">
														<input type="radio" name="single-quantity" id="radio-single-quantity-unltd" <?php echo ($pCouponQuantity == 0)? 'checked="checked"':''; ?> /> <span id="radio-single-quantity-unltd-label"><?php echo __('unlimited'); ?></span>
													</span>
	                      </li>
											<?php } ?>
											</ul>
											</li>

											<li id="multiple-code-row" class="clearfix" <?php echo ($pCouponType=='single')? 'style="display:none;"': ''; ?>>
											<ul class="clearfix">
												<!-- ********** Configure multiple codes ********** -->
												<li class="clearfix">
		                      	<div class="btnwording alignleft">
		                      		<strong><?php echo $pForm['deal']['coupon']['multiple_codes']->renderLabel();?></strong>
		                      	</div>
		                      	<label>
		                      		<span>
		                      			<?php echo $pForm['deal']['coupon']['multiple_codes']->render();?>
		                      		</span>
		                      	</label>
		                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['coupon']['multiple_codes']->renderError();?></div>
												</li>
												<li class="clearfix">
		                      	<div class="btnwording alignleft">
		                      		<strong><?php echo $pForm['deal']['coupon_quantity']->renderLabel();?></strong><span><?php echo $pForm['deal']['coupon_quantity']->renderError();?></span>
		                      	</div>
		                      	<label>
		                      		<span>
																<?php if($lIsEdit) { ?>
																	<?php echo __('Will end after <span id="code-counter">%codecounter%</span> likes.', array('%codecounter%' => $lDeal->getCouponQuantity())); ?>
																	<?php echo __('%oldcodes% remaining old coupon codes', array('%oldcodes%' => $lDeal->getCouponQuantity()-$lDeal->getClaimedQuantity())); ?>
																<?php } else { ?>
																	<?php echo __('Will end after <span id="code-counter">%codecounter%</span> likes.', array('%codecounter%' => '0')); ?>
																<?php } ?>
		                      		</span>
		                      	</label>
												</li>
												</ul>
											</li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong><?php echo $pForm['deal']['redeem_url']->renderLabel();?></strong>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['redeem_url']->render(array('class' => 'mirror-value wd320'));?>
                      		</span>
                      	</label><span class="requirrow alignleft"><?php echo __('(required)'); ?></span>
                      	<div class="content-error-box clearfix"><?php echo $pForm['deal']['redeem_url']->renderError();?></div>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="grboxbot"><span></span></div>
          </div>


        <!-- ********** Configure choose categories ********** -->

       	<div class="popoboxpad">
        	<div class="grboxtop"><span></span></div>
          <div class="grboxmid">
          	<div class="grboxmid-content">
            	<div class="graybox clearfix">
              	<h2 class="btntitle"><span>4</span><?php echo __('Choose categories')?></h2>
                <ul class="btnformlist">
                	<li class="clearfix">
                  	<div class="btnwording alignleft">
                  		<strong><?php echo $pForm['deal']['addtags']->renderLabel();?></strong><span><?php echo $pForm['deal']['addtags']->renderError();?></span>
                  	</div>
                    <span><?php echo $pForm['deal']['addtags']->render();?></span>
                  </li>
                  <li class="clearfix" id="deal_tag_row" <?php echo ($pAddtags=='addnotags')? 'style="display:none;"': ''; ?>>
                  	<div class="btnwording alignleft">&nbsp;</div>
                    <label class="textfield-wht">
                    	<span><?php echo $pForm['deal']['tags']->render(array('class' => 'wd320'));?></span>
                    </label>
										<div class="content-error-box clearfix"><?php echo $pForm['deal']['addtags']->renderError();?></div>
                  </li>


                </ul>
              </div>
            </div>
          </div>
	        <div class="grboxbot"><span></span></div>


          <div class="clearfix">
          	<div id="accept-tos">
            	<?php echo $pForm['deal']['tos_accepted']->render(array('class' => 'left'));?>
            	<span><?php echo __($pForm['deal']['tos_accepted']->renderLabel(), array('%terms%' => link_to(__('Terms of Deals'), '/', array('target' => '_blank'))));?></span><br />
            	<?php echo $pForm['deal']['tos_accepted']->renderError();?>
						</div>
          	<span class="alignright cancelbox"><?php echo link_to('or Cancel', 'deals/index');  ?></span>
            <div class="alignleft bysubmit">
              <a class="graybtnwide alignleft" id="proceed-deal-button" title="Copy code" href="#"><span>Submit a deal</span></a>
              <!-- input type="submit" value="Deal anlegen" id="proceed-deal-button" class="graybtnwide alignleft" -->
            </div>
          </div>
        </div>
			</div>
    </div>
  </div>
</div>
</div>
<div class="grboxbot"><span></span></div>
<!--veryfied box end -->
</form>