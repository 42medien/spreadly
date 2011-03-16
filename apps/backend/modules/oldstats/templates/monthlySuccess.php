<?php use_helper('I18N', 'Date') ?>
<?php include_partial('deal/assets') ?>

<div id="sf_admin_container">
  <h1>Old Statistics</h1>

  <div class="clearfix content-header-box" id="filter">
    <form name="visit-history-form" class="left" id="visit-history-form" action="/backend.php/oldstats/monthly">
      <div class="form-area" style="float:left;">
        <label for="month">Month</label>
        <input type="text" name="month" id="month" value="<?php echo $pMonth;?>" class="tooltip" title="Choose date to filter for a special month" />
      </div>
      <div class="form-area" style="float:left;">
        <label for="search">Domain</label>
        <input name="host" type="text" value="<?php echo $pHost; ?>" class="tooltip" title="Enter letters to filter for domains" />
      </div>
      <div class="form-area" style="float:left;margin-top:20px; margin-left:15px;">
        <input type="submit" value="Filter"/>
      </div>
    </form>

    <form name="visit-history-form" class="left" id="visit-history-form" action="/backend.php/oldstats/monthly">
      <div class="form-area" style="float:left;margin-top:20px; margin-left:15px;">
        <input type="submit" value="Reset"/>
      </div>
    </form>
  </div>
  
  

  <?php $lOrder = $pSortOrder=='asc'?'desc':'asc'; ?>
  <div class="sf_admin_list">
    <table class="full sheet" id="monthly_table">
      <thead>
        <tr>
          <th>Rank</th>
          <th class="tooltip" title="Inspected Domain">Domain</th>
          <th class="tooltip" <?php echo $pSortCat=='pis_total'?'class="active"':''; ?> title="Page Impressions"><?php echo link_to('PIs', 'oldstats/monthly?sort=pis_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
          <th class="tooltip" <?php echo $pSortCat=='act_total'?'class="active"':''; ?> title="Sum of Positive and Negative Activities"><?php echo link_to('Activities', 'oldstats/monthly?sort=act_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
          <th class="tooltip" <?php echo $pSortCat=='likes_total'?'class="active"':''; ?> title="Positive Activities"><?php echo link_to('Positive', 'oldstats/monthly?sort=likes_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
          <th class="tooltip" <?php echo $pSortCat=='dislikes_total'?'class="active"':''; ?> title="Negative Activities"><?php echo link_to('Negative', 'oldstats/monthly?sort=dislikes_total&order='.$lOrder.'&month='.$pMonth.'&host='.$pHost); ?></th>
        </tr>
      </thead>

      <tbody>
      <?php $i=1;?>
          <?php foreach($lVisits as  $lVisit) { ?>
            <tr>
              <td><?php echo (($pPage*20)-20)+$i++."."; ?></td>
              <td class="domain"><?php echo $lVisit['host']; ?></td>
              <td class="pis"><?php echo $lVisit['pis_total']; ?></td>
              <td class="activities"><?php echo $lVisit['act_total'];?></td>
              <td class="likes"><?php echo $lVisit['likes_total']; ?></td>
              <td class="dislikes"><?php echo $lVisit['dislikes_total']; ?></td>
            </tr>
          <?php } ?>
      </tbody>
  
      <tfoot>
        <tr>
          <td colspan="9">
            <ul class="pager">
              <li class="tooltip" title="Number of inspected domains for month <?php echo $pMonth; ?>"><?php echo $lHostCount; ?> Results</li>
              <?php if($pPage > 1) { ?>
                <li><span><?php echo link_to('First Page', 'oldstats/monthly?page=1'.$pQuery, array('title' => 'Go to First Page', 'class' => 'tooltip')); ?></span></li>
                <li><span><?php echo link_to('&lt; Previous Page', 'oldstats/monthly?page='.($pPage-1).$pQuery, array('title' => 'Go to Previous Page', 'class' => 'tooltip')); ?></span></li>
              <?php } ?>
              <li><span><?php echo link_to('Next Page &gt;', 'oldstats/monthly?page='.($pPage+1).$pQuery, array('title' => 'Go to Next Page', 'class' => 'tooltip')); ?></span></li>
              <li><span><?php echo link_to('Last Page', 'oldstats/monthly?page='.ceil($lHostCount/20).$pQuery, array('title' => 'Go to Last Page', 'class' => 'tooltip')); ?></span></li>
            </ul>
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>