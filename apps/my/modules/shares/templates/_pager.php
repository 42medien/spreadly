<?php if ($pager->haveToPaginate()) { ?>
<div class="pagination">
  <ul>
    <li><?php echo link_to('&laquo;', 'shares/index?page='.$pager->getFirstPage().'&'.$query, array('title' => __('first page'))) ?></li>
    <?php $links = $pager->getLinks(); foreach ($links as $page) { ?>
    <li <?php echo ($page == $pager->getPage())?'class="active"':''; ?>>
      <?php echo link_to($page, 'shares/index?page='.$page.'&'.$query  , array('title' => __('to page') . ' ' . $page)) ?>
    </li>
    <?php } ?>
    <li><?php echo link_to('&raquo;', 'shares/index?page='.$pager->getLastPage().'&'.$query, array('title' => __('last page'))) ?></li>
  </ul>
</div>
<?php } ?>