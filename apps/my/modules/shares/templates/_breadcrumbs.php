<ul class="breadcrumb">
  <li>
    <?php echo link_to(__("Home"), "shares/index"); ?>
  </li>
  <li>
    <?php if ($sf_request->getParameter("t")) { ?>
    <span class="divider">/</span> <a href="#"><?php echo __("Tag"); ?>: <?php echo $sf_request->getParameter("t"); ?></a>
    <?php } ?>
  </li>
  <li>
    <?php if ($sf_request->getParameter("s")) { ?>
    <span class="divider">/</span> <a href="#"><?php echo __("Search"); ?>: <?php echo $sf_request->getParameter("s"); ?></a>
    <?php } ?>
  </li>
  <li>
    <?php if ($sf_request->getParameter("p")) { ?>
    <span class="divider">/</span> <a href="#"><?php echo __("Page"); ?>: <?php echo $sf_request->getParameter("p"); ?></a>
    <?php } ?>
  </li>

  <li>
    <?php if (isset($results)) { ?>
    <span class="divider">/</span> <?php echo __("Results") . ": " . $results; ?>
    <?php } ?>
  </li>
</ul>