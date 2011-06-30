<ul class="errors">
<?php foreach ($pErrors as $e) { ?>
  <li>
    <small>@ 14.10.1978</small>
    <h3>
      <strong><em><?php echo UserTable::getInstance()->find($e->getUId())->getFullname(); ?></em></strong> made a mistake on
      <strong><em><?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getCommunity()->getName(); ?></em></strong>
      (<?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getProfileUri(); ?>)
    </h3>
    Error: {<?php echo $e->getCode(); ?>} <?php echo $e->getMessage(); ?>
  </li>
<?php } ?>
</ul>