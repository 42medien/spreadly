<h1>Approve Deals</h1>

<ul class="approve_deals">
  <?php foreach ($deals as $deal): ?>
  <li>
    <div class="info">
      <h1><?php echo $deal->getName(); ?></h1>
      <h2>A <b><?php echo $deal->getBillingType()==DealTable::BILLING_TYPE_LIKE ? 'Like' : 'Media Penetration'; ?></b> Deal on <?php echo link_to($deal->getSpreadUrl(), $deal->getSpreadUrl()); ?></h2>
      <h2>Submitted on <?php echo date("d. F Y", strtotime($deal->getUpdatedAt())); ?></h2>
    </div>
    <div class="action">
      <?php echo link_to('Edit &amp; Approve', url_for('approve_deal/approve?deal_id='.$deal->getId()), 'class="btn"' ); ?>
    </div>
  </li>
  <?php endforeach; ?>
</ul>
