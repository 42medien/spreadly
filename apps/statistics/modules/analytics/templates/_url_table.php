<?php use_helper('Date', 'DomainProfiles') ?>
<table id="analytics_url_table" cellspacing="0" class="full sheet">
  <thead>
    <tr>
      <th>&nbsp;</th>
      <th>&nbsp;</th>
      <th><?php echo __('Clickbacks');?></th>
      <th><?php echo __('Distribution');?></th>
      <th><?php echo __('Activities');?></th>
      <th><?php echo __('Likes');?></th>
      <th><?php echo __('Dislikes');?></th>
      <th><?php echo __('Reach');?></th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($pData['data'] as $i => $data): ?>
      <tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>">
      	<td><?php echo ++$i;?>.</td>
        <td><?php echo link_to($data['url'], '@get_analytics_urls', array('query_string' => 'com=all&url='.$data['url'].'&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-url-filter-link'));  ?></td>
        <td class="numeric"><?php echo $data['pis']['cb'] ?></td>
        <td class="numeric"><?php echo $data['distribution'] ?>%</td>
        <td class="numeric"><?php echo $data['neg']+$data['pos'] ?></td>
        <td class="numeric"><?php echo $data['pos'] ?></td>
        <td class="numeric"><?php echo $data['neg'] ?></td>
        <td class="numeric"><?php echo $data['contacts'] ?></td>
      </tr>
    <?php endforeach; ?>
  </tbody>
  <tfoot>
    <tr>
      <td colspan="8">&nbsp;</td>
    </tr>
  </tfoot>
</table>