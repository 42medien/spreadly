<div id="branding">
  <div id="language_selection" class="right">
    <ul>
      <?php /*foreach ( LanguagePeer::getSupportedLanguages() as $culture ) { ?>
        <?php if($culture == 'de' || $culture == 'en') { ?>
          <li class="menu-lang<?php if ($sf_user->getCulture() != $culture) { echo ' lang_inactive'; } ?>">
            <?php echo link_to(cdn_image_tag('/img/icons/flags/'.$culture.'.gif', array('alt' => $culture, 'title' => format_language($culture))), 'components/language?lang='.$culture); ?>
          </li>
        <?php } ?>
      <?php }*/ ?>
    </ul>
  </div>
</div>