<?php foreach($lLanguages as $lLang) { ?>
  <?php if ($sf_user->getShortedCulture() != $lLang) { ?>
    <a href="<?php echo url_for('@update_language?lang='.$lLang); ?>" 
      class="icon_language_select" id="language_selecten_icon_<?php echo $lLang; ?>_inactive" 
      title="<?php echo __('Show yiid in %1', array('%1' => $lCultureInstance->getLanguage($lLang))); ?>">&nbsp;</a>
  <?php } else { ?>
    <a href="<?php echo url_for('@update_language?lang='.$lLang); ?>" 
      class="icon_language_select" id="language_selecten_icon_<?php echo $lLang; ?>_active" 
      title="<?php echo __('Show yiid in %1', array('%1' => $lCultureInstance->getLanguage($lLang))); ?>">&nbsp;</a>
  <?php } ?>
<?php } ?>