<?php
use_helper('Avatar', 'Text');

$lImages = $pYiidMeta->getImages();
if ($lImages && count($lImages) > 0) {
  $lImage = $lImages[0];
} else {
  $lImage = "";
}
?>

<div class="title">
  <h1><?php echo __("Share this page with your friends"); ?></h1>
</div>
<div class="clear"></div>

<form action="" name="popup-like-form" id="popup-like-form" method="post">

<div class="sh_content">
  <div class="sh_img_block scrollable" id="myscroll">
    <div id="scroll-meta-images" class="scrollable imgbg items">
      <?php include_partial('like/meta_images_list', array('pImages' => $lImages)); ?>
    </div>
    <div class="navbt" id="scroll-button-area">
      <div class="back prev browse left">
        <div class="backbtn"><a href="#">&#139;</a></div>
      </div>
      <div class="forward next browse right">
        <div class="fwdbtn"><a href="#">&#155;</a></div>
      </div>
    </div>
  </div>
  <div class="sh_info">
    <h2 title="<?php echo $pYiidMeta->getTitle(); ?>"><?php echo truncate_text($pYiidMeta->getTitle(), 50); ?></h2>
    <p title="<?php echo $pYiidMeta->getDescription(); ?>">
      <?php echo truncate_text($pYiidMeta->getDescription(), 150); ?>
    </p>
    <p><a href="<?php echo truncate_text($pYiidMeta->getUrl(), 50); ?>" target="_blank" title="<?php echo $pYiidMeta->getUrl(); ?>">
      <?php echo truncate_text($pYiidMeta->getUrl(), 50); ?></a></p>
  </div>
  <div class="clear"></div>
  <div class="pers_comments">
    <textarea id="texarea_count" rows="2" cols="20" placeholder="<?php echo __("add your comment (optional) ..."); ?> <?php echo __('Feel free to add some hashtags, for example:'); ?> #like"></textarea>
    <div class="clear"></div>
    <span id="chars_counter">0</span>
  </div>
</div>

<!--div class="bookmarking">
  <div class="separator"></div>
  <div class="bookmarking_line">
    <div class="book_title">Tag your bookmark <span>(seperate tags with a comma)</span></div>
    <div class="checkbox">
		  <span class="bg_checkbox">
        <input type="checkbox" class="checkbox-input"/>
        <span class="box"><span class="tick"></span></span>
		  </span>
      <div class="check_label">Public Bookmark</div>
    </div>
  </div>
  <div class="add_tags">
    <div class="tag">
      <ul>
        <li>
          <div class="tagcont">
            <div class="tagtxt">Business-on</div>
            <input type="hidden" name="tags[]" value="Business-on" />
          </div>
        </li>
        <li>
          <div class="tagcont">
            <div class="tagtxt">Lorem Ipsum</div>
            <input type="hidden" name="tags[]" value="Lorem Ipsum" />
          </div>
        </li>
        <li class="last-input">
          <input id="key_enter" type="text" placeholder="Enter your tag here..."/>
        </li>
      </ul>
      <div class="clear"></div>
    </div>
  </div>
</div-->

<div class="sh_networks">
  <div class="gradient">
    <h1>Choose the networks you want to post to</h1>
    <div class="sh_networks_content">
      <div class="add_networks">
        <div class="networks_icon">
          <?php include_component("like", "share_section", array('pError' => $pError)); ?>
        </div>
        <div class="addnet">
          <ul>
            <li class="plusbtn">
              <ul>
                <li><a href="#" class="fb" onclick="window.open('<?php echo url_for("@signinto?service=facebook"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
                <li><a href="#" class="tw" onclick="window.open('<?php echo url_for("@signinto?service=twitter"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
                <li><a href="#" class="xg" onclick="window.open('<?php echo url_for("@signinto?service=xing"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
                <li><a href="#" class="lkd" onclick="window.open('<?php echo url_for("@signinto?service=linkedin"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
                <!--li><a href="#" class="mrwong"></a></li>
                <li><a href="#" class="yig"></a></li-->
                <li><a href="#" class="tmbl" onclick="window.open('<?php echo url_for("@signinto?service=tumblr"); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
                <li><a href="#" class="fltr" onclick="window.open('<?php echo url_for("@signinto?service=flattr"); ?>', 'auth_popup', 'width=800,height=700,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;"></a></li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
      <div class="<?php if ($sf_user->isAuthenticated()) { echo 'sharebtn-active'; } else { 'sharebtn'; } ?>">
        <div class="sharebtn_graphic">
          <input type="submit" name="shared" value="share &amp; bookmark" <?php if (!$sf_user->isAuthenticated()) { echo 'disabled="disabled"'; } ?>/>
          <span></span>
        </div>
      </div>
    </div>
    <div class="clear"></div>
  </div>
</div>

<input type="hidden" name="like[thumb]" id="like-img-value" value="<?php echo $lImage; ?>" />
<input type="hidden" name="like[title]" value="<?php echo htmlspecialchars($pYiidMeta->getTitle()); ?>" />
<input type="hidden" name="like[descr]" value="<?php echo htmlspecialchars($pYiidMeta->getDescription()); ?>" />
<input type="hidden" name="like[url]" value="<?php echo $pYiidMeta->getUrl(); ?>" />
<input type="hidden" name="like[tags]" value="<?php echo $pYiidMeta->getTags(); ?>" />
<input type="hidden" name="like[clickback]" value="<?php echo $sf_request->getParameter('clickback'); ?>" />
</form>

<?php if ($trackingUrl) { ?>
  <iframe src="<?php echo $trackingUrl; ?>" style="width: 0px; height: 0px; display: none;"></iframe>
<?php } ?>