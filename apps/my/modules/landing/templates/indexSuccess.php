<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <h1><?php echo __("Die private Sammlung my.spread.ly"); ?></h1>
  <p><?php echo __("Alle eigenen Bookmarks sowie alle selbst geteilten Inhalte auf einen Blick."); ?></p>
  <p><?php echo __("Login/Signup with"); ?>: <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=twitter"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/twitter-favicon.gif") . " " . __("Twitter"); ?></a>
    <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=facebook"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/facebook-favicon.gif") . " " . __("Facebook"); ?></a>
    <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=linkedin"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/linkedin-favicon.gif") . " " . __("LinkedIn"); ?></a>
    <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=xing"); ?>', 'auth_popup', 'width=580,height=550,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/xing-favicon.gif") . " " . __("XING"); ?></a></p>
</div>

<div class="row">
  <div class="span4">
    <h2><?php echo __("Statistiken"); ?></h2>
    <p><?php echo __("Ihre Aktivitäten Social Sharing und Social Bookmarking werden hier ausgewertet und Sie erfahren Details über Ihr eigenes Verhalten / Social Behavior."); ?></p>
  </div>
  <div class="span4">
    <h2><?php echo __("Spread Rank"); ?></h2>
    <p><?php echo __("Sie wollen den Vergleich zu den anderen ziehen? Dann können Sie hier Ihren persönlichen Spread Rank errechnen lassen. Den Spread Rank können Sie als Bookmark oder Share in Ihren Social Media- Kanälen verbreiten und Ihre Popularität messen."); ?></p>
  </div>
  <div class="span4">
    <h2><?php echo __("Für Blogger und Publisher"); ?></h2>
    <p><?php echo __("Mit Spreadly haben Sie keine „Buttonwüste“ mehr, sondern nur einen einzigen Share-Button ohne auf nur ein einziges Netzwerk verzichten zu müssen. Nutzen Sie die Reichweite von Facebook, Twitter, LinkedIn und Google+ (in Arbeit) für Ihre Artikel, Produkte und anderen Inhalte. Ihre Besucher brauchen nur einen Button zu klicken, um alle ihre Freunde in den Netzwerken zu erreichen."); ?></p>
    <p><a class="btn btn-info" href="http://spreadly.com" target="_blank"><?php echo __("Please visit Spreadly.com"); ?> &raquo;</a></p>
  </div>
</div>