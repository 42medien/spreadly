<div class="btn-group pull-right">
  <a href="<?php echo url_for("shares/index")."?".$od_query; ?>"  class="btn<?php if ($order_by_date) { echo " btn-inverse"; }; ?>">
    <?php echo __("Date"); ?>
    <?php if ($order_by_date && $order_by_date == "desc") { ?>
      <i class="icon-chevron-down"></i>
    <?php } elseif ($order_by_date && $order_by_date == "asc") { ?>
      <i class="icon-chevron-up"></i>
    <?php } ?>
  </a>
  <a href="<?php echo url_for("shares/index")."?".$oc_query; ?>" class="btn<?php if ($order_by_clickback) { echo " btn-inverse"; }; ?>">
    <?php echo __("Clickbacks"); ?>
    <?php if ($order_by_clickback && $order_by_clickback == "desc") { ?>
      <i class="icon-chevron-down"></i>
    <?php } elseif($order_by_clickback && $order_by_clickback == "asc") { ?>
      <i class="icon-chevron-up"></i>
    <?php } ?>
  </a>
</div>