<table id="domain_profiles_table" cellspacing="0" class="full sheet">
  <thead>
    <tr>
      <th><?php echo __('URL'); ?></th>
      <th><?php echo __('Activities'); ?></th>
      <th><?php echo __('Positives'); ?></th>
      <th><?php echo __('Negatives'); ?></th>
      <th><?php echo __('Media penetration'); ?></th>
      <th><?php echo __('Clickbacks'); ?></th>
    </tr>
  </thead>
  <tbody>
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
  </tbody>
  <tfoot>
    <tr>
      <td colspan="7">&nbsp;</td>
    </tr>
  </tfoot>
</table>