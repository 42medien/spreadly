<form action="<?php echo url_for('deals/save'); ?>" method="post" id="save_deal_form" name="save_deal_form">
<?php echo $pForm['id']->render();?>
<?php echo $pForm['_csrf_token']->render(); ?>
<div class="content-box bg-white">
	<div class="clearfix">
		<div class="left" id="deal-teaser-img">
			<?php echo image_tag('/img/global/42x42/promotion.png'); ?>
		</div>
		<p class="deal-teaser-text left">
			<?php echo __('Confirm your deal: running on www.marketingboerse.de from 2010/07/08 to 2010/08/08, limited to 100 deals in total'); ?>
		</p>
	</div>

	<div class="content-col-twothird left clearfix">
		<div class="content-box bg-white">
		  <div class="form-row">
				<input type="radio" name="getdealcode" id="radio-has-code" value="false" checked="checked"> <?php echo __('Have you already integrated the default yiid button in all the places you wish your deal to show up? You\'re all set!'); ?>
			</div>
			<div class="form-row">
				<input type="radio" name="getdealcode" id="radio-no-code" value="true"> <?php echo __('You don\'t have integrated any button codes in your site yet? Please click here and copy & paste the following code to your site:'); ?>
			</div>
		</div>
		<div class="content-box bg-white hide" id="no-code-box">
			<h3><?php echo __('Copy that code!'); ?></h3>
			<div class="form-row">
				<textarea id="deal_button_code"><?php include_partial('likebutton/widget_like', array('pUrl' => '', 'pLang' => '', 'pType' => 'like', 'pFontColor' => '#000', 'pShort' => 0, 'pSocial' => 0, 'pWidth' => '420', 'pHeight' => '25')); ?></textarea>
			</div>
			<h3><?php echo __('Parameters that should change on a per page basis:'); ?></h3>
			<div class="form-row">
				<div class="label-box">
					<?php echo __('url');?>
				</div>
				<div>
					<?php echo __('The URL to like (defaults to the page the button can be found on)'); ?>
				</div>
			</div>
			<div class="form-row">
				<div class="label-box">
					<?php echo __('title');?>
				</div>
				<div>
					<?php echo __('Page title (defaults to "Deal Summary")'); ?>
				</div>
			</div>
			<div class="form-row">
				<div class="label-box">
					<?php echo __('photo');?>
				</div>
				<div>
					<?php echo __('URL of an image from your post (defaults to screenshot of url)'); ?>
				</div>
			</div>
			<div class="form-row">
				<div class="label-box">
					<?php echo __('description');?>
				</div>
				<div>
					<?php echo __('Short summary (defaults to "How to claim")'); ?>
				</div>
			</div>
			<h3><?php echo __('Optional'); ?></h3>
			<div class="form-row">
				<div class="label-box">
					<?php echo __('lang');?>
				</div>
				<div>
					<?php echo __('International country code (ISO 3166) (defaults to the language you\'re using to configure)'); ?>
				</div>
			</div>
			<h3><?php echo __('Send code and description via email to your webmaster:'); ?></h3>
			<div class="form-row">
				<input type="text" id="admin-email" name="admin-email" value="<?php echo __('comma seperated list of emails'); ?>" class="left"/>
			</div>
		</div>
	  <div class="form-row" id="terms-of-use">
			<?php echo $pForm['tos_accepted']->render(array('class' => 'left'));?>
			<?php echo $pForm['tos_accepted']->renderLabel('tos_accepted', array('id' => 'tos_label'));?>
			<?php echo $pForm['tos_accepted']->renderError();?>
		</div>
		<input type="submit" class="button positive" id="save-deal-button" value="<?php echo __('Save', null, 'widget');?>" />
	</div>

	<div class="content-col-third left clearfix">
		<div class="content-box bg-white">
			  <div class="clearfix preview-deal-box" id="preview-deal-button">
		      <img src="/img/global/yiid-btn-like-en.png" class="left"/>
		      <div class="deal_button_wording-mirror">dat wat im button zu stehn hat</div>
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
</div>
</form>