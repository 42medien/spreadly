<?php echo include_partial('filter', array('lVerifiedDomains' => $lVerifiedDomains, 'pHost' => $pHost)) ?>

<div class="content-box">
  <div id="chart" style="height: 400px;"></div>
</div>

<div class="content-box">
  <?php $lOrder = $pSortOrder=='asc'?'desc':'asc'; ?>
  <table id="monthly_table" cellspacing="0" class="full sheet">
    <thead>
      <tr>
        <th class="tooltip" title="Inspected Domain">Domain</th>
        <th class="tooltip" <?php echo $pSortCat=='pis_total'?'class="active"':''; ?> title="Page Impressions"><?php echo link_to('PIs', 'visit_history/monthly?sort=pis_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
        <th class="tooltip" <?php echo $pSortCat=='act_total'?'class="active"':''; ?> title="Sum of Positive and Negative Activities"><?php echo link_to('Activities', 'visit_history/monthly?sort=act_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
        <th class="tooltip" <?php echo $pSortCat=='likes_total'?'class="active"':''; ?> title="Positive Activities"><?php echo link_to('Positive', 'visit_history/monthly?sort=likes_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
        <th class="tooltip" <?php echo $pSortCat=='dislikes_total'?'class="active"':''; ?> title="Negative Activities"><?php echo link_to('Negative', 'visit_history/monthly?sort=dislikes_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
      </tr>
    </thead>

    <tbody>
      <?php foreach($lVisits as $i => $lVisit) { ?>
        <tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>">
            <th class="domain"><?php echo $lVisit['host']; ?></th>
            <td class="pis numeric"><?php echo $lVisit['pis_total']; ?></td>
            <td class="activities numeric"><?php echo $lVisit['act_total'];?></td>
            <td class="likes numeric"><?php echo $lVisit['likes_total']; ?></td>
            <td class="dislikes numeric"><?php echo $lVisit['dislikes_total']; ?></td>
          </tr>
        <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="6">
          <ul class="pager">
            <li class="tooltip" title="Number of inspected domains for month <?php echo $pMonth; ?>"><?php echo $lHostCount; ?> Results</li>
            <?php if($pPage > 1) { ?>
              <li><span><?php echo link_to('First Page', 'visit_history/monthly?page=1'.$pQuery, array('title' => 'Go to First Page', 'class' => 'tooltip')); ?></span></li>
              <li><span><?php echo link_to('&lt; Previous Page', 'visit_history/monthly?page='.($pPage-1).$pQuery, array('title' => 'Go to Previous Page', 'class' => 'tooltip')); ?></span></li>
            <?php } ?>
            <li><span><?php echo link_to('Next Page &gt;', 'visit_history/monthly?page='.($pPage+1).$pQuery, array('title' => 'Go to Next Page', 'class' => 'tooltip')); ?></span></li>
            <li><span><?php echo link_to('Last Page', 'visit_history/monthly?page='.ceil($lHostCount/20).$pQuery, array('title' => 'Go to Last Page', 'class' => 'tooltip')); ?></span></li>
          </ul>
        </td>
      </tr>
    </tfoot>
  </table>
</div>
