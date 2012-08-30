<title>shared by <?php echo $user->getFullname(); ?></title>
<id>tag:spreadly.com,<?php echo date("Y"); ?>:api.spreadly.com/feeds/<?php echo $user->getUsername(); ?></id>
<?php
foreach ($activities as $activity) {
  include_partial("atom_entry", array("activity" => $activity));
}
?>