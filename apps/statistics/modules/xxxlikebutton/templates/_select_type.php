<?php
  $lSessionUser = sfContext::getInstance()->getUser();
  $lSessionUser->setCulture('en');
  //var_dump($pCulture);die();
?>
<select name="likebutton[t]" id="type-en" <?php if($pCulture == 'en'){ ?>class="show likebutton_t"<?php } else { ?>class="hide likebutton_t"<?php } ?>>
  <option value="like" selected="selected"><?php echo __('WORDINGSELECT_LIKE', null, 'configurator'); ?></option>
  <option value="pro"><?php echo __('WORDINGSELECT_PRO', null, 'configurator'); ?></option>
  <option value="recommend"><?php echo __('WORDINGSELECT_RECOMMEND', null, 'configurator'); ?></option>
  <option value="visit"><?php echo __('WORDINGSELECT_VISIT', null, 'configurator'); ?></option>
  <option value="nice"><?php echo __('WORDINGSELECT_NICE', null, 'configurator'); ?></option>
  <option value="buy"><?php echo __('WORDINGSELECT_BUY', null, 'configurator'); ?></option>
  <option value="rsvp"><?php echo __('WORDINGSELECT_RSVP', null, 'configurator'); ?></option>
</select>

<?php $lSessionUser->setCulture('de'); ?>
<select name="likebutton[t]" id="type-de" <?php if($pCulture == 'de'){?>class="show likebutton_t" <?php } else { ?>class="hide likebutton_t" <?php } ?>>
  <option value="like" selected="selected"><?php echo __('WORDINGSELECT_LIKE', null, 'configurator'); ?></option>
  <option value="pro"><?php echo __('WORDINGSELECT_PRO', null, 'configurator'); ?></option>
  <option value="recommend"><?php echo __('WORDINGSELECT_RECOMMEND', null, 'configurator'); ?></option>
  <option value="visit"><?php echo __('WORDINGSELECT_VISIT', null, 'configurator'); ?></option>
  <option value="nice"><?php echo __('WORDINGSELECT_NICE', null, 'configurator'); ?></option>
  <option value="buy"><?php echo __('WORDINGSELECT_BUY', null, 'configurator'); ?></option>
  <option value="rsvp"><?php echo __('WORDINGSELECT_RSVP', null, 'configurator'); ?></option>
</select>

<?php $lSessionUser->setCulture('tr'); ?>
<select name="likebutton[t]" id="type-tr" <?php if($pCulture == 'tr'){?>class="show likebutton_t" <?php } else { ?>class="hide likebutton_t" <?php } ?>>
  <option value="like" selected="selected">Beġendim / Beġenmekten vazgeçtim</option>
  <option value="pro">Ben varim/ Ben yokum</option>
  <option value="recommend">Tavsiye edilir / Tavsiye edilmez</option>
  <option value="visit">Bende oradaydım / Ben orada deġildim</option>
  <option value="nice">Güzel buluyorum / Çirkin buluyorum</option>
  <option value="buy">Ben istiyorum / Ben istemiyorum</option>
  <option value="rsvp">Ben geliyorum / Ben gelmiyorum</option>
</select>

<?php $lSessionUser->setCulture($pCulture); ?>