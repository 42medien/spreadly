<!-- Main hero unit for a primary marketing message or call to action -->
<div class="hero-unit">
  <h1><?php echo __("Welcome to my.spread.ly"); ?></h1>
  <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
  <p><?php echo __("Login/Signup with"); ?>: <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=twitter"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/twitter-favicon.gif") . " " . __("Twitter"); ?></a>
            <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=facebook"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/facebook-favicon.gif") . " " . __("Facebook"); ?></a>
            <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=linkedin"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/linkedin-favicon.gif") . " " . __("LinkedIn"); ?></a>
            <a href="#" class="btn bn-large" onclick="window.open('<?php echo url_for(sfConfig::get("app_settings_widgets_url")."/auth/signinto?service=xing"); ?>', 'auth_popup', 'width=580,height=550,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"><?php echo image_tag("/img/xing-favicon.gif") . " " . __("XING"); ?></a></p>
</div>

<div class="row">
  <div class="span4">
    <h2><?php echo __("Statistics"); ?></h2>
    <p><?php echo __("View detailed statistics of your sharing behaviour. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."); ?></p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h2><?php echo __("Spread Rank"); ?></h2>
    <p>Get and share your Spread-Rank with your friends. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
    <p><a class="btn" href="#">View details &raquo;</a></p>
  </div>
  <div class="span4">
    <h2><?php echo __("Are you a publisher/blogger"); ?></h2>
    <p><?php echo __("Dank Spreadly haben Sie keine Buttonwüste mehr, sondern nur einen Share-Button und müssen trotzdem auf kein Netzwerk verzichten. Nutzen Sie die Reichweite von Facebook, Twitter, LinkedIn und Google+ (in Arbeit) für Ihre Artikel, Produkte und anderen Inhalte. Ihre Besucher brauchen nur einen Button zu klicken um alle ihre Freunde in den Netzwerken zu erreichen"); ?></p>
    <p><a class="btn btn-info" href="http://spreadly.com" target="_blank"><?php echo __("Please visit Spreadly.com"); ?> &raquo;</a></p>
  </div>
</div>