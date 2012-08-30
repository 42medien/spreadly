<?php use_helper("Date"); ?>
<dd class="shadow-light bordered-light">
  <div class="commentbox clearfix">
    <?php echo __("%1 ago", array("%1" => time_ago_in_words($pActivity->getC()))); ?>
    <p>
      <strong title="<?php echo $pActivity->getTitle(); ?>"><?php echo truncate_text($pActivity->getTitle(), 50); ?></strong>
      <?php
        if (strlen($pActivity->getTitle()) < 20) {
        $lDescrCount = 50 - strlen($pActivity->getTitle());
      ?>
         - <span title="<?php echo $pActivity->getDescr() ?>"><?php echo truncate_text($pActivity->getDescr(), $lDescrCount) ?></span>
      <?php } ?>
      <br />
      <a href="<?php echo $pActivity->getUrl(); ?>" target="_blank" title="<?php echo $pActivity->getUrl(); ?>"><?php echo truncate_text($pActivity->getUrl(), 70); ?></a>
    </p>
  </div>
</dd>