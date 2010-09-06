<h1><?php echo __('HEADLINE_PRESS_ARCHIVE')?></h1>
<p class="newsletter-register-description"><?php echo __('DESCRIPTION_PRESS_ARCHIVE')?></p>
<table  class="styled">
        <tr>
          <th><?php echo __('DATE')?></th>
          <th><?php echo __('NEWSLETTER')?></th>
        </tr>
        <?php 
          $class = '' ;
          foreach ($pData as $row) {
        ?>
        <tr class="<?php echo $class; ?>">
          <td><?php echo date('d.m.Y', $row['date']); ?></td>
          <td><?php echo link_to($row['subject'], $row['link']['html'], array('target' => '_blank'))?></td>
        </tr>
        <?php $class == '' ? $class = 'alternate' : $class = ''; ?>
        <?php } ?>
</table>
