<?php use_helper('Date', 'DomainProfiles') ?>


<table id="analytics_url_table" cellspacing="0" class="full sheet">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th><?php echo __('Clickbacks');?></th>
      <th><?php echo __('Spreading');?></th>
      <th><?php echo __('Activities');?></th>
      <th><?php echo __('Likes');?></th>
      <th><?php echo __('Dislikes');?></th>
      <th><?php echo __('Range');?></th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>1.</td>
      <td><?php echo link_to('http://www.example.com/dumdidum=true', '@get_analytics_url_details', array('query_string' => 'com=all&url=http://www.example.com/dumdidum=true&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></td>
      <td>23%</td>
      <td>112</td>
      <td>75</td>
      <td>37</td>
      <td>7265</td>
    </tr>
  	<!--
    <?php foreach($pData['data'] as $i => $data): ?>
      <tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>">
        <td><?php echo $data['url'] ?></td>
        <td class="numeric"><?php echo $data['total'] ?></td>
        <td class="numeric"><?php echo $data['pos'] ?></td>
        <td class="numeric"><?php echo $data['neg'] ?></td>
        <td class="numeric"><?php echo $data['contacts'] ?></td>
        <td class="numeric"><?php echo $data['pis']['cb'] ?></td>
      </tr>
    <?php endforeach; ?>
     -->
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>

