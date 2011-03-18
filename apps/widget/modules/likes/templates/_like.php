<?php use_helper("Date"); ?>
<dd>
  <div class="commentbox clearfix">
    <strong><?php echo $pActivity->getUser()->getFullname() ?></strong> <span class="timeago"><?php echo __("%1 ago", array("%1" => time_ago_in_words($pActivity->getC()))); ?></span>
    <p>
      <strong title="<?php echo $pActivity->getTitle(); ?>"><?php echo truncate_text($pActivity->getTitle(), 45); ?></strong>
      <?php
        if (strlen($pActivity->getTitle()) < 20) {
        $lDescrCount = 45 - strlen($pActivity->getTitle());
      ?>
         - <span title="<?php echo $pActivity->getDescr() ?>"><?php echo truncate_text($pActivity->getDescr(), $lDescrCount) ?></span>
      <?php } ?>
      <br />
      <a href="<?php echo $pActivity->getUrl(); ?>" target="_blank" title="<?php echo $pActivity->getUrl(); ?>"><?php echo truncate_text($pActivity->getUrl(), 70); ?></a>
    </p>
  </div>
</dd>