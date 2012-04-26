<div class="page-header">
  <h1><?php echo __("Hello"); ?> <?php echo $user->getFullName(); ?>!</h1>
</div>

<div class="row">
  <div class="span1">
    <div class="thumbnail"><img src="<?php echo $user->getAvatar(); ?>" /></div>
  </div>
  <div class="span11">
    <h2><i class="icon-comments"></i> <?php echo __("Your Networks"); ?></h2>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><?php echo __("Community"); ?></th>
          <th><?php echo __("Profile"); ?></th>
          <th><?php echo __("Friends"); ?></th>
          <th><?php echo __("Spreads"); ?></th>
          <th><?php echo __("Klout Score"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($user->getOnlineIdentities() as $online_identity) { ?>
        <tr>
          <td><?php echo $online_identity->getCommunity(); ?></td>
          <td><?php echo $online_identity->getName(); ?></td>
          <td><?php echo $online_identity->getFriendCount(); ?></td>
          <td><?php echo $online_identity->getSpreadCount(); ?></td>
          <td><?php echo $online_identity->getKloutRank(); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>