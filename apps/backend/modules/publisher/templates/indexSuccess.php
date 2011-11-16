<div id="sf_admin_container">
  <div id="sf_admin_content">
    <h2>Publisher Payments</h2>

    <form method="get">
    <p>für Monat:
    <select name="date">
    <?php foreach ($dates as $date) { ?>
      <option value="<?php echo $date['month'] . "." . $date['year']; ?>"><?php echo date("M o", strtotime($date['created_at'])); ?></option>
    <?php } ?>
    </select><input type="submit" /></p>
    </form>

    <div class="sf_admin_list">
      <table cellspacing="0">
        <thead>
          <tr>
            <th class="sf_admin_text">Domain</td>
            <th class="sf_admin_text">E-Mail</td>
            <th class="sf_admin_text">Likes</td>
            <th class="sf_admin_text">Price</td>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($commissions as $commission) { ?>
          <tr class="sf_admin_row odd">
            <td class="sf_admin_text"><?php echo DomainProfileTable::getInstance()->find($commission['domain_profile_id'])->getDomain(); ?></td>
            <td class="sf_admin_text"><?php echo DomainProfileTable::getInstance()->find($commission['domain_profile_id'])->getSfGuardUser()->getEmailAddress(); ?></td>
            <td class="sf_admin_text"><?php echo $commission['count']; ?></td>
            <td class="sf_admin_text"><?php echo round($commission['sum'], 2, PHP_ROUND_HALF_UP); ?> €</td>
          </tr>
        <?php } ?>
        </tbody>
      </table>
    </div>
  </div>
</div>