<div id="footer" class="clearfix">
  <div class="content_wrapper clearfix supportlinks">
    <div class="innerTitle">
      <h5><?php echo __('YIID_SUPPORTS'); ?></h5>
    </div>
    <!-- end innerTitle -->
    <ul class="List clearfix" id="supportlinks">
      <li><?php echo link_to(cdn_image_tag('/img/partner_openid.png', array('alt' => 'OpenID')), 'http://www.openid.net', array('rel'=> 'nofollow', 'title'=>'openID')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_microformats.png', array('alt' => 'Microformats')), 'http://microformats.org', array('rel'=> 'nofollow', 'title'=>'Microformats')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_a.png', array('alt' => 'OAuth')), 'http://oauth.net', array('rel'=> 'nofollow', 'title'=>'oauth')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_opensocial.png', array('alt' => 'OpenSocial')), 'http://www.opensocial.org', array('rel'=> 'nofollow', 'title'=>'opensocial')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_rss.png', array('alt' => 'RSS')), 'http://www.rssboard.org/', array('rel'=> 'nofollow', 'title'=>'rss')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_target.png', array('alt' => 'OPML')), 'http://www.opml.org', array('rel'=> 'nofollow', 'title'=>'OPML')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_atom.png', array('alt' => 'APML')), 'http://www.apml.org', array('rel'=> 'nofollow', 'title'=>'APML')); ?></li>
      <li><?php echo link_to(cdn_image_tag('/img/partner_rdf.png', array('alt' => 'RDF')), 'http://www.w3.org/RDF/', array('rel'=> 'nofollow', 'title'=>'RDF')); ?></li>
    </ul>
  </div>
  <!-- end contentwrapper -->

 <div id = "footer-entries">
  <?php foreach($categories as $category) { ?>
  <ul>
    <li><h5><?php echo $category->getTitle(); ?></h5></li>
    <?php foreach($category->getCmss() as $cms) { ?>
      <?php if ($cms->getActive()) { ?>
        <?php if ($cms->getLink()) { ?>
          <li><?php echo link_to($cms->getHeadline(), $cms->getLink()); ?></li>
        <?php } else { ?>
          <li><?php echo link_to_frontend($cms->getHeadline(), 'static/index?category='.$cms->getCmsCategory()->getPage().'&page='.$cms->getPage());  ?></li>
        <?php } ?>
      <?php } ?>
    <?php } ?>
  </ul>
  <?php } //end foreach categories ?>
 </div>
</div>