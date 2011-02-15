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

<?php if($lIsEdit) { ?>
	<div class="content-header-box">
		<div class="content-box-head">
			<h3><?php echo __('+ Editing an Ad')?></h3>
	  </div>
	  <div class="content-box-body">
	  	<?php echo __('Button wording, deal description, scheduling and quantity fields are pre-populated with your existing deal settings. Edits you make here will replace your existing deal. Once you submit your changes, your deal will stop running until it has been approved by our team.'); ?>
	  </div>
	</div>
<?php } ?>

<form action="" method="post" id="deal_form" name="deal_form">
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
              	<?php echo $pForm['id']->render(array('class' => "custom-select"));?>
              </label>
            </div>
            <p><?php echo __('Push your content into social networks through recommendations. Only one deal per domain at a time. Please allow 24 hours for reviewing new or changed deals.'); ?></p>
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
                      </li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong class="singleline"><?php echo $pForm['deal']['start_date']->renderLabel();?></strong>
                      	</div>
                      	<label class="textfield-wht">
                      		<span>
                      			<?php echo $pForm['deal']['start_date']->render(array("class" => "wd60"));?>
                      		</span>
                      	</label> <span class="deshline alignleft">-</span>
                      	<label class="textfield-wht">
                      		<span>
														<?php echo $pForm['deal']['end_date']->render(array("class" => "wd60"));?>
                      		</span>
                      	</label>
                      	<span class="requirrow alignleft"><?php echo __('(One active deal per domain at a time!)'); ?></span>
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


                    	<li class="clearfix">
                      	<div class="btnwording alignleft"><strong>URL to redeem Coupon-Codes:</strong> </div>
                        <div class="alignleft onlycheckbox">
                        	<div class="chcodepad">
                        		<span class="checkboxwht">
                        			<label class="radio-btn"> <input type="checkbox" name="" /></label>
                        		</span>Only one code
                        	</div>
                          <span class="checkboxwht"><label class="radio-btn"> <input type="checkbox" name="" /></label></span>Only one code
                        </div>
                        <label class="textfield-wht"><span><input type="text" class="wd278" value="enter your code here ..." /></span></label>
                      </li>




                      <li class="clearfix">
												<div class="btnwording alignleft">
													<strong class="singleline">Quantity:</strong>
												</div>
												<span class="onlyone alignleft">Only one code</span>
												<label class="textfield-wht">
													<span><input type="text" class="wd15" value="100" /></span>
												</label>
												<span class="requirrow alignleft">likes</span>
                      </li>
                      <li class="clearfix">
                      	<div class="btnwording alignleft">
                      		<strong class="singleline">Coupon-Codes:</strong>
                      	</div>
                      	<label class="textfield-wht">
                      		<span><input type="text" class="wd320" value="http://www.marketingboerse.de/coupons" /></span>
                      	</label>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <div class="grboxbot"><span></span></div>
          </div>










                                   <div class="clearfix">
                                   		 <span class="alignright cancelbox">  <a href="#">or Cancel</a></span>
                                   		<div class="alignleft bysubmit">
                                      	<span>By submitting a deal you accept the Yiid Terms Of Deals Agreement.</span><br />

                                    	<a class="graybtnwide alignleft" title="Copy code" href="#"><span>Submit a deal</span></a></div>
                                   </div>
                                </div>



                          </div>

                        </div>
                  </div>
                </div>
                <div class="grboxbot"><span></span></div>
            </div>
            <!--veryfied box end -->


</form>