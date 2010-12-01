<?php if(isset($pEdited) && $pEdited == true) { ?>
  <div class="content-box bg-white">
 		<h3><?php echo __('Editing an Ad')?></h3>
 		<div>
 			<?php echo __('Butoon wording, deal description, scheduling and quantity fields are pre-populated with your existing deal settings. Edits you make here will replace your existing deal. Once you submit your changes, your deal will stop running until it has been approved by our team.'); ?>
 		</div>
  </div>
<?php } ?>

<form action="<?php echo url_for('deals/proceed'); ?>" method="post" id="deal_form" name="deal_form">
<?php echo $pForm['deal']['id']->render();?>
<?php echo $pForm['_csrf_token']->render(); ?>

  <div id="create-deal-content">
		<div class="content-header-box" id="creat-deal-box">
		  <div class="content-box-head">
		    <h3><?php echo __('+ Create New Deal')?></h3>
		  </div>
		  <div class="content-box-body" id="claiming-profile-content">

  <?php echo $pForm->renderGlobalErrors();?>

  <div class="left" id="deal-teaser-img">
    <?php echo image_tag('/img/global/42x42/promotion.png'); ?>
  </div>
  <div class="clearfix" id="deal-domain-select-box">
		<?php echo $pForm['id']->render();?><br />
		<?php echo __('Push your content into social networks through recommendations. Only one deal per domain at a time. Please allow 24 hours for reviewing new or changed deals. '); ?>
  </div>
  <div class="content-box bg-white">
	  <h2><?php echo __('Step 1: Create your Button')?></h2>
	  <div class="left form-row">
	  	<div class="label-box">
		    <?php echo $pForm['deal']['button_wording']->renderLabel();?>
		    <div class="meta-label"><?php echo __('Max. <span id="button_wording_counter">35</span> characters'); ?></div>
	    	<?php echo $pForm['deal']['button_wording']->renderError();?>
		  </div>
	    <?php echo $pForm['deal']['button_wording']->render(array('class' => 'mirror-value'));?>
	  </div>
	  <div class="clearfix preview-deal-box" id="preview-deal-button">
      <img src="/img/global/yiid-btn-like-en.png" class="left"/>
      <div class="deal_button_wording-mirror">dat wat im button zu stehn hat</div>
	  </div>
  </div>

  <div class="content-box bg-white">
    <h2><?php echo __('Step 2: Configure your Coupon')?></h2>
    <div class="left">
    	<div class="form-row">
	  		<div class="label-box">
					<?php echo $pForm['deal']['summary']->renderLabel();?>
					<div class="meta-label"><?php echo __('Max. <span id="summary_counter">40</span> characters'); ?></div>
					<?php echo $pForm['deal']['summary']->renderError();?>
				</div>
				<?php echo $pForm['deal']['summary']->render(array('class' => 'mirror-value'));?>
			</div>
			<div class="form-row">
				<div class="label-box">
					<?php echo $pForm['deal']['description']->renderLabel();?>
					<div class="meta-label"><?php echo __('Max. <span id="description_counter">80</span> characters'); ?></div>
					<?php echo $pForm['deal']['description']->renderError();?>
				</div>
				<?php echo $pForm['deal']['description']->render(array('class' => 'mirror-value'));?>
			</div>
			<div class="form-row">
				<div class="label-box">
					<?php echo $pForm['deal']['start_date']->renderLabel();?>
					<?php echo $pForm['deal']['end_date']->renderError();?>
					<?php echo $pForm['deal']['start_date']->renderError();?>
				</div>
				<?php echo $pForm['deal']['start_date']->render();?> -
				<?php echo $pForm['deal']['end_date']->render();?>
			</div>
			<div class="form-row">
				<div class="label-box">
      		<?php echo $pForm['deal']['terms_of_deal']->renderLabel();?>
      		<?php echo $pForm['deal']['terms_of_deal']->renderError();?>
      	</div>
      	<?php echo $pForm['deal']['terms_of_deal']->render();?>
      </div>
			<div class="form-row">
				<div class="label-box">
      		<?php echo $pForm['imprint_url']->renderLabel();?>
      		<?php echo $pForm['imprint_url']->renderError();?>
				</div>
      	<?php echo $pForm['imprint_url']->render();?><br />
      </div>
    </div>
    <div class="clearfix preview-deal-box">
        <div class="content-box">
        	<div class="content-box yellow">
          	<div class="coupon-summary deal_summary-mirror">Kostenloser Probemonat</div>
          	<div class="coupon-description deal_description-mirror">
          		Liken und damit einmalig pro Person einen freien Probemonat gewinnen!
          	</div>
          	<div class="coupon-foot">Expires at <span id="deal_end_date-mirror">2010/12/31 23:59 GMT</span>  |  87/100 left</div>
          </div>
          <div class="meta-label">
          	<input type="checkbox" name="coupon-accept-tod" id="coupon-accept-tod" /><span>Ich erkenne die <a href="/">Teilnahmebedingungen</a> an</span>
          </div>
          <img src="/img/global/yiid-btn-like-en.png"/>
          <div style="text-align: right;"><a href="/">Impressum</a></div>
        </div>
    </div>
  </div>

  <div class="content-box bg-white">
    <h2><?php echo __('Step 3: Configure your Coupon after a Like')?></h2>
    <div class="left">
    	<div class="form-row">
    		<div class="label-box">
    			<?php echo $pForm['deal']['coupon_type']->renderLabel();?>
					<?php echo $pForm['deal']['coupon_type']->renderError();?>
				</div>
				<?php echo $pForm['deal']['coupon_type']->render();?>
			</div>

			<div id="single-code-row" <?php echo ($pCouponType=='multiple')? 'style="display:none;"': ''; ?>>
	    	<div class="form-row" id="single-code-row">
	    		<div class="label-box">
	    			<?php echo $pForm['deal']['coupon']['single_code']->renderLabel();?>
						<?php echo $pForm['deal']['coupon']['single_code']->renderError();?>
					</div>
					<?php echo $pForm['deal']['coupon']['single_code']->render();?>
				</div>
	    	<div class="form-row clearfix">
	    		<div class="label-box">
	    			<?php echo $pForm['deal']['coupon_quantity']->renderLabel();?>
						<?php echo $pForm['deal']['coupon_quantity']->renderError();?>
					</div>
					<div class="inline-row">
						<div class="label-box">
							<input type="radio" name="single-quantity" id="radio-single-quantity" <?php echo ($pCouponQuantity > 0)? 'checked="checked"':''; ?> />
							<?php echo __('Will end after');?>
						</div>
						<?php echo $pForm['deal']['coupon_quantity']->render();?>
						<?php echo __('likes'); ?>
					</div>
					<div class="inline-row" id="single-quantity-unlimited">
						<input type="radio" name="single-quantity" id="radio-single-quantity-unltd" <?php echo ($pCouponQuantity == 0)? 'checked="checked"':''; ?> />
						<?php echo __('unlimited'); ?>
					</div>
				</div>
			</div>

			<div id="multiple-code-row" <?php echo ($pCouponType=='single')? 'style="display:none;"': ''; ?>>

	    	<div class="form-row">
	    		<div class="label-box">
	    			<?php echo $pForm['deal']['coupon']['multiple_codes']->renderLabel();?>
	    			<div class="meta-label"><?php echo __('Paste codes coma-separated or one code per line'); ?></div>
						<?php echo $pForm['deal']['coupon']['multiple_codes']->renderError();?>
					</div>
					<?php echo $pForm['deal']['coupon']['multiple_codes']->render();?>
				</div>
	    	<div class="form-row">
	    		<div class="label-box">
	    			<?php echo $pForm['deal']['coupon_quantity']->renderLabel();?>
					</div>
					<?php echo __('Will end after 87 likes (quantity of your coupon codes).'); ?>
				</div>
		 </div>



			<div class="form-row">
    		<div class="label-box">
					<?php echo $pForm['deal']['redeem_url']->renderLabel();?>
					<?php echo $pForm['deal']['redeem_url']->renderError();?>
				</div>
				<?php echo $pForm['deal']['redeem_url']->render(array('class' => 'mirror-value'));?>
			</div>
    </div>
    <div class="clearfix preview-deal-box">
        <div class="content-box">
        	<div class="content-box yellow">
          	<div class="coupon-summary deal_summary-mirror">Kostenloser Probemonat</div>
          	<div class="coupon-description">
          		<p><?php echo __('Ihr Gutschein-Code:'); ?></p>
          		<p><strong>JFJKALEJJ191949</strong></p>
          	</div>
          	<div class="coupon-foot">Expires at 2010/12/31 23:59 GMT  |  87/100 left</div>
          	<a href="/" class="deal_redeem_url-mirror">http://www.marketingboerse.de/coupons</a>
          </div>
        </div>
    </div>
  </div>
  <div class="form-row" id="terms-of-use">
		<?php echo $pForm['deal']['tos_accepted']->render(array('class' => 'left'));?>
		<?php echo $pForm['deal']['tos_accepted']->renderLabel('tos_accepted', array('id' => 'tos_label'));?>
		<?php echo $pForm['deal']['tos_accepted']->renderError();?>
	</div>
	<?php //echo $pForm['tos_accepted']->renderError();?>
	<input type="submit" class="button positive" id="proceed-deal-button" value="<?php echo __('Submit Deal >>', null, 'widget');?>" />
	<?php echo __('or'); ?>
	<?php echo link_to('Cancel', 'deals/get_create_index', array('class' => 'link-deal-content')); ?>
		  </div>
		</div>
  </div>
</form>