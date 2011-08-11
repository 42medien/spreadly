<ul class="errors">
<?php
foreach ($pErrors as $e) {
  $user = UserTable::getInstance()->find($e->getUId());
?>
  <li>
    <small class="meta"><?php echo $e->getC()->format("d.m.Y @ H:i:s"); ?><br />
    <?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getProfileUri(); ?>
    <?php if ($user && $user->getEmail()) { echo "<br />".$user->getEmail(); } ?>
    </small>
    <h3>
      <strong><em><?php echo $user ? $user->getFullname() : 'n/a'; ?></em></strong>s
      <strong><em><?php echo OnlineIdentityTable::getInstance()->find($e->getOiId())->getCommunity()->getName(); ?></em></strong>-account has hiccups
    </h3>
    <p>Error: {<?php echo $e->getCode(); ?>} <?php echo $e->getMessage(); ?></p>
  </li>
<?php } ?>
</ul>