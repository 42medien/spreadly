<?php
if ($pager->haveToPaginate()) {
  if ($query) {
    $query = "&".$query;
  }
?>
<div class="pagination pull-right">
  <ul>
    <li><?php echo link_to('&laquo;', 'shares/global', array('title' => __('first page'), "query_string" => "p=".$pager->getFirstPage().$query)) ?></li>
    <?php $links = $pager->getLinks(); foreach ($links as $page) { ?>
    <li <?php echo ($page == $pager->getPage())?'class="active"':''; ?>>
      <?php echo link_to($page, 'shares/global'  , array('title' => __('to page') . ' ' . $page, "query_string" => "p=".$page.$query)) ?>
    </li>
    <?php } ?>
    <li><?php echo link_to('&raquo;', 'shares/global', array('title' => __('last page'), "query_string" => "p=".$pager->getLastPage().$query)) ?></li>
  </ul>
</div>
<?php } ?>