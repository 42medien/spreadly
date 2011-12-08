	<div class="grboxtop"><span></span></div>
  <div class="grboxmid">
  	<div class="grboxmid-content">
			<div class="graybox clearfix veryficationbox">
      	<h3 class="verifytitle"><?php echo __('Claim your sites')?></h3>
        <p><?php echo __('Please confirm that you are the owner oder admin of the website. The verifictaion of your domain ownership is required for activating the deal function of the Spread.ly button as well as the statistics section. Please do not hesitate to contact us if any problems occur.'); ?> <a href="mailto:info@spreadly.com">info@spreadly.com</a></p>
				<div class="httpblock">
					<form action="<?php echo url_for('domain_profiles/create'); ?>" method="post" <?php $form->isMultipart() and print 'enctype="multipart/form-data" ' ?> id="new_domain_profile_form">
						<?php echo $form->renderHiddenFields(false); ?>
						<fieldset>
        			<label id="http-sel">
        				<?php echo $form['protocol']->render(array('class' => 'custom-select')); ?>
        			</label>
        			<label class="textfield-wht"><span>://<?php echo $form['url']->render(array('class' => 'wd740')); ?></span></label>
        			<label class="save"><span><input type="submit" name="" value="<?php echo __('Save', null, 'widget');?>" /></span></label>
    				</fieldset>
					</form>
					<div id="add-url-error" class="error"></div>
 				</div>
      </div>
    </div>
  </div>
  <div class="grboxbot"><span></span></div>
