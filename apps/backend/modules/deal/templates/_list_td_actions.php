<td>
  <ul class="sf_admin_td_actions">
    <?php echo $helper->linkToEdit($deal, array(  'params' =>   array(  ),  'class_suffix' => 'edit',  'label' => 'Edit',)) ?>
    <?php echo $helper->linkToDelete($deal, array(  'params' =>   array(  ),  'confirm' => 'Are you sure?',  'class_suffix' => 'delete',  'label' => 'Delete',)) ?>
  </ul>
  <ul class="sf_admin_td_actions">
    <?php include_partial('deal/event_actions', array('deal' => $deal)) ?>
  </ul>
</td>
