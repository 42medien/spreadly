<?php
foreach ($activities as $activity) {
  include_partial("atom_entry", array("activity" => $activity));
}
?>