<?php use_helper('Text', 'Favicon'); ?>

<p class="shorturl-description">YIID.cc is a Service of <a href="http://www.yiid.com">YIID</a> (Your Internet ID).</p>

<?php if ($shortUrl) { ?>
  <p id="shorturl"><?php echo ($shortUrl); ?></p>

  <ul class="service-list">
    <li><?php echo link_to(favicon_tag("http://twitter.com", array("alt" => "tweet this!")) . " tweet this!", "http://twitter.com/home?status=$shortUrl", array('target' => '_blank')) ?></li>
    <li><?php echo link_to(favicon_tag("http://plurk.com", array("alt" => "plurk this!")) . " plurk this!", "http://plurk.com/?status=$shortUrl", array('target' => '_blank')) ?></li>
    <li><?php echo link_to(favicon_tag("http://ping.fm", array("alt" => "ping this!")) . " ping this!", "http://ping.fm/ref/?method=microblog&title=Cool+Link&link=$shortUrl", array('target' => '_blank')) ?></li>
  </ul>
<?php } ?>

<div class="url-boxerle">
  <form action="<?php echo url_for('@homepage') ?>" method="POST" class="clearfix">
    <div class="clearfix">
	    <span class="left outerRight">Shorten a URL</span>
      <?php echo $form['_csrf_token']->render(); ?>
	    <?php echo $form['url']->render(array('class'=>'inputtext shorturl-text')); ?><input type="submit" value="submit" class="button green small" />
	    <?php echo $form['url']->renderError(); ?>
	  </div>
  </form>
</div>

<p>The latest Short-URLs</p>

<table>
  <thead>
    <tr>
      <th>URL</th>
      <th>Short URL</th>
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

<hr />

<p>Drag this link to your bookmarks-bar to shorten every link you like: <a href="javascript:void(window.open(location.href='<?php echo sfConfig::get('app_settings_short_url'); ?>/?url='+encodeURIComponent(location.href)));" class="bookmarklet" title="Drag this on your browser's bookmark toolbar">yiid this!</a><p>

<small class="subline">The best friend of <?php echo link_to('brrr.at', 'http://www.brrr.at'); ?></small>