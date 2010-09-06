  <h1><?php echo $headline->getTitle(); ?></h1>
  <ul>
  <?php foreach ($lCmsLinks as $lCmsLink) { ?>
    <?php if ($lCmsLink->getLink()) { ?>
    <li><?php echo link_to($lCmsLink->getHeadline(), $lCmsLink->getLink()); ?></li>
    <?php } else { ?>
    <li><?php echo link_to($lCmsLink->getHeadline(), 'static/index?category='.$lCmsLink->getCmsCategory()->getPage().'&page='.$lCmsLink->getPage());  ?></li>
    <?php } ?>
  <?php } ?>
  </ul>
