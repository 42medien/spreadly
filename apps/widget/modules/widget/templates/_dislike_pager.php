<?php
if($pPage) {
  $lPage = $pPage;
} elseif($sf_params->getRawValue()->get('page', 1)) {
  $lPage = $sf_params->getRawValue()->get('page', 1);
} else {
  $lPage = 1;
}
?> 
<li id="stream-pager">  
  <a href="#content-wrapper" class="top-link"><?php echo __('GO_TOP'); ?></a>
  <?php  echo link_to(__('SHOW_MORE_DISLIKES'), '@index_get_dislikes?page='.++$lPage, array('class'=>'dislike-pager-link')); ?>
</li>