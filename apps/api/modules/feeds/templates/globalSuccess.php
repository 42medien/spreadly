<title>global share stream</title>
<id>tag:spreadly.com,<?php echo date("Y"); ?>:api.spreadly.com/feeds/global</id>
<?php
foreach ($activities as $activity) {
  include_partial("atom_entry", array("activity" => $activity));
}
?>