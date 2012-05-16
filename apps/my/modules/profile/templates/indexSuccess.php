<div class="page-header">
  <h1><?php echo __("Hello"); ?> <?php echo $user->getFullName(); ?>!</h1>
</div>

<div class="row">
  <div class="span3">
    <div class="well">
      <h3>Subscribe</h3>

      <ul>
        <li class="icon-feed"><?php echo link_to("Atom-Feed", "profile/atom_feed", array("query_string" => "id=".$user->getUsername())); ?></li>
      </ul>

      <h3>Export</h3>

      <ul>
        <li>coming soon...</li>
      </ul>
    </div>
  </div>
  <div class="span9">
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

    <h2><i class="icon-gift"></i> <?php echo __("Your Deals"); ?></h2>

    <table class="table table-bordered table-striped">
      <thead>
        <tr>
          <th><?php echo __("Title"); ?></th>
          <th><?php echo __("Description"); ?></th>
          <th><?php echo __("Coupon/URL"); ?></th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($activities as $activity) { ?>
        <tr>
          <td><?php echo $activity->getDeal()->getMotivationTitle(); ?></td>
          <td><?php echo $activity->getDeal()->getMotivationText(); ?></td>
          <td><?php include_partial("profile/coupon_".$activity->getDeal()->getCouponType(), array("activity" => $activity)); ?></td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>