<ul class="errors">
<?php foreach ($pErrors as $e) { ?>
  <li>
    <small class="meta"><?php echo $e->getC()->format("d.m.Y @ H:i:s"); ?><br /><?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getProfileUri(); ?></small>
    <h3>
      <strong><em><?php echo UserTable::getInstance()->find($e->getUId())->getFullname(); ?></em></strong>s
      <strong><em><?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getCommunity()->getName(); ?></em></strong>-account has hiccups
    </h3>
    <p>Error: {<?php echo $e->getCode(); ?>} <?php echo $e->getMessage(); ?></p>
  </li>
<?php } ?>
</ul>