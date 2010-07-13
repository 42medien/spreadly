<?php
//use_helper('Text', 'Favicon', 'Form');

if ($sf_user->isAuthenticated()) {
  $session_user = $sf_user->getUser();
} else {
  $session_user = null;
}

#echo include_partial("index/vcard", array("pUser" => $session_user));
?>

<h1>YIID.cc</h1>

<p class="shorturl-description"><?php echo __('SHORT_URL_DESCRIPTION', array('%1' => link_to(__('YIID'), sfConfig::get('app_settings_url')))); ?></p>

<?php if ($shortUrl) { ?>
  <p id="shorturl"><?php echo ($shortUrl); ?></p>

  <ul class="service-list">
    <li><?php echo link_to(favicon_tag("http://twitter.com", array("alt" => "tweet this!")) . " tweet this!", "http://twitter.com/home?status=$shortUrl", array('target' => '_blank')) ?></li>
    <li><?php echo link_to(favicon_tag("http://plurk.com", array("alt" => "plurk this!")) . " plurk this!", "http://plurk.com/?status=$shortUrl", array('target' => '_blank')) ?></li>
    <li><?php echo link_to(favicon_tag("http://ping.fm", array("alt" => "ping this!")) . " ping this!", "http://ping.fm/ref/?method=microblog&title=Cool+Link&link=$shortUrl", array('target' => '_blank')) ?></li>
  </ul>
<?php } ?>

<div class="url-boxerle">
  <form action="<?php echo url_for('index/index') ?>" method="POST" class="clearfix">
    <div class="clearfix">
	    <span class="left outerRight"><?php echo $form['url']->renderLabel(); ?></span>
      <?php echo $form['_csrf_token']->render(); ?>
	    <?php echo $form['url']->render(array('class'=>'inputtext shorturl-text')); ?>
	    <div style="line-height:15px;"><input type="submit" value="<?php echo __('SUBMIT_BUTTON'); ?>" class="button green small" /></div>
	    <?php echo $form['url']->renderError(); ?>
	  </div>

    <?php if ($session_user) { ?>
      <div class="clearfix send-yiidcc-activity">
        <input type="checkbox" id="add_activity" name="add_activity" /><?php echo label_for('add_activity', __('ADD_SHORT_AS_ACTIVITY')); ?>
      </div>
    <?php } ?>
  </form>
</div>

<p class=""><?php echo __('LAST_SHORT_URLS'); ?></p>

<table class="url-list styled">
  <thead>
    <tr>
      <th><?php echo __('URL'); ?></th>
      <th><?php echo __('SHORT_URL'); ?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($pShortUrls as $lShortUrl) { ?>
    <tr>
      <td><?php echo truncate_text($lShortUrl->getUrl(), 50, "..."); ?></td>
      <td><?php echo link_to($lShortUrl->getShortedUrl(), $lShortUrl->getShortedUrl()); ?></td>
    </tr>
    <?php } ?>
  </tbody>
</table>

<p><?php echo __('BOOKMARKLET_DESCRIPTION'); ?>:</p>

<a href="javascript:void(window.open(location.href='<?php echo sfConfig::get('app_settings_short_url'); ?>/?url='+encodeURIComponent(location.href)));" class="bookmarklet" title="Drag this on your browser's bookmark toolbar">yiid this!</a>

<small class="subline">The best friend of <?php echo link_to('brrr.at', 'http://www.brrr.at'); ?></small>