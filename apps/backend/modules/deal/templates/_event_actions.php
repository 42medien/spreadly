<?php foreach ($deal->getEventNames() as $event): ?>
  <?php if($deal->canTransitionFor($event)): ?>
    <li>
      <?php echo link_to(ucfirst($event), 'deal/transition_for?deal_id='.$deal->getId().'&event='.$event, 'post=true'); ?>
    </li>
  <?php endif; ?>
<?php endforeach; ?>  
