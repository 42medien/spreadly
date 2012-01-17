<ul>
<?php
foreach ($aas as $aa) {
  echo "<li>".$aa->getTitle()."</li>";
  echo "<li>".$aa->getIUrl()."</li>";
  echo "<li>".$aa->getDId()."</li>";
}
?>
</ul>