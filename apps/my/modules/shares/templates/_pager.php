<?php
if ($pager->haveToPaginate()) {
  $lSearchValue = "";
  if (isset($search)) {
    $lSearchValue = "&search=".$search;
  }
?>
<div class="pagination">
  <ul>
    <li><?php echo link_to('&laquo;', 'shares/index?page='.$pager->getFirstPage().$lSearchValue, array('title' => __('first page'))) ?></li>
    <?php $links = $pager->getLinks(); foreach ($links as $page) { ?>
    <li <?php echo ($page == $pager->getPage())?'class="active"':''; ?>>
      <?php echo link_to($page, 'shares/index?page='.$page.$lSearchValue, array('title' => __('to page') . ' ' . $page)) ?>
    </li>
    <?php } ?>
    <li><?php echo link_to('&raquo;', 'shares/index?page='.$pager->getLastPage().$lSearchValue, array('title' => __('last page'))) ?></li>
  </ul>
</div>
<?php } ?>