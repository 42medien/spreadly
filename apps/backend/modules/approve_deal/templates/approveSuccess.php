<div class="deal">
  <h1><?php echo $deal->getName(); ?></h1>
  <h2>A <b><?php echo $deal->getBillingType()==DealTable::BILLING_TYPE_LIKE ? 'Like' : 'Media Penetration'; ?></b> Deal on <?php echo link_to($deal->getSpreadUrl(), $deal->getSpreadUrl()); ?></h2>
  <h2>Submitted on <?php echo date("d. F Y", strtotime($deal->getUpdatedAt())); ?> by <?php echo link_to('#'.$deal->getSfGuardUserId().' - '. $deal->getSfGuardUser()->getEmailAddress(), 'sf_guard_user_edit', $deal->getSfGuardUser()) ?></h2>

  <div class="clearfix">
    <div class="column">
      <h3>Details for Deal <?php echo link_to('#'.$deal->getId(), 'deal_edit', $deal) ?></h3>
      <dl>
        <dt>Name</dt>
        <dd><?php echo $deal->getName() ?></dd>

        <dt>Type</dt>
        <dd><?php echo $deal->getType() ?></dd>

        <dt>Pool Hits</dt>
        <dd><?php echo $deal->getPoolHits() ?></dd>

      </dl>

      <h3>Motivation</h3>
      <dl>
        <dt>Title</dt>
        <dd><?php echo $deal->getMotivationTitle() ?></dd>

        <dt>Text</dt>
        <dd><?php echo $deal->getMotivationText() ?></dd>
      </dl>
    </div>

    <div class="column">
      <h3>Spread</h3>
      <dl>
        <dt>Title</dt>
        <dd><?php echo $deal->getSpreadTitle() ?></dd>

        <dt>Text</dt>
        <dd><?php echo $deal->getSpreadText() ?></dd>

        <dt>URL</dt>
        <dd><?php echo link_to($deal->getSpreadUrl(), $deal->getSpreadUrl()) ?></dd>

        <dt>Image</dt>
        <dd><img src="<?php echo $deal->getSpreadImg() ?>" style="max-width: 50px; max-height:50px;" /><?php echo $deal->getSpreadImg() ?></dd>

        <dt>TOS</dt>
        <dd><?php echo $deal->getSpreadTos() ?></dd>

      </dl>
    </div>

    <div class="column">
      <h3>Coupon</h3>
      <dl>
        <dt>Type</dt>
        <dd><?php echo $deal->getCouponType() ?></dd>

        <dt>Title</dt>
        <dd><?php echo $deal->getCouponTitle() ?></dd>

        <dt>Text</dt>
        <dd><?php echo $deal->getCouponText() ?></dd>

        <dt>Code</dt>
        <dd><?php echo $deal->getCouponCode() ?></dd>

        <dt>URL</dt>
        <dd><?php echo $deal->getCouponUrl() ? link_to($deal->getCouponUrl(), $deal->getCouponUrl()) : 'n/a' ?></dd>

        <dt>Webhook URL</dt>
        <dd><?php echo $deal->getCouponWebhookUrl() ? link_to($deal->getCouponWebhookUrl(), $deal->getCouponWebhookUrl()) : 'n/a' ?></dd>

        <dt>Redeem URL</dt>
        <dd><?php echo $deal->getCouponRedeemUrl() ? link_to($deal->getCouponRedeemUrl(), $deal->getCouponRedeemUrl()) : 'n/a' ?></dd>

      </dl>
    </div>

    <div class="column">
      <h3>Billing</h3>
      <dl>
        <dt>Billing type</dt>
        <dd><?php echo $deal->getBillingType() ?></dd>

        <dt>Actual quantity/Target quantity</dt>
        <dd><?php echo $deal->getActualQuantity() ?>/<?php echo $deal->getTargetQuantity() ?></dd>

        <dt>Price</dt>
        <dd><?php echo $deal->getPrice() ? $deal->getPrice() : 'n/a' ?></dd>

        <dt>Commission pot</dt>
        <dd><?php echo $deal->getCommissionPot() ? $deal->getCommissionPot() : 'n/a' ?></dd>

        <dt>Commission percentage</dt>
        <dd><?php echo $deal->getCommissionPercentage() ? $deal->getCommissionPercentage() : 'n/a' ?></dd>

        <dt>Commission per unit</dt>
        <dd><?php echo $deal->getCommissionPerUnit() ? $deal->getCommissionPerUnit() : 'n/a' ?></dd>

        <dt>PaymentMethod</dt>
        <dd><?php echo $deal->getPaymentMethod() ?></dd>
      </dl>
    </div>
  </div>

  <div class="column">
    <h3>Enter commission percentage</h3>
    <form action="/backend.php/approve_deal/approve" method="post" class="geil">
      <input type="hidden" value="put" name="sf_method">
      <?php echo $form['id'] ?>
      <?php echo $form['target_quantity'] ?>

      <fieldset class="control-group">
        <?php echo $form['price']->renderLabel() ?>
        <div class="controls">
          <?php echo $form['price_dummy']->render(array('disabled' => 'disabled', 'value' => $deal->getPrice())) ?>
          <?php echo $form['price'] ?>
        </div>
      </fieldset>

      <fieldset class="control-group">
        <?php echo $form['commission_percentage']->renderLabel() ?>
        <div class="controls">
          <?php echo $form['commission_percentage'] ?>
        </div>
      </fieldset>
      <?php?>
      <fieldset class="control-group">
        <?php echo $form['commission_pot']->renderLabel() ?>
        <div class="controls">
          <?php echo $form['commission_pot_dummy']->render(array('disabled' => 'disabled', 'value' => $deal->getCommissionPot())) ?>
          <?php echo $form['commission_pot'] ?>
        </div>
      </fieldset>

      <fieldset class="control-group">
        <?php echo $form['commission_per_unit']->renderLabel() ?>
        <div class="controls">
          <?php echo $form['commission_per_unit_dummy']->render(array('disabled' => 'disabled', 'value' => $deal->getCommissionPerUnit())) ?>
          <?php echo $form['commission_per_unit'] ?>
        </div>
      </fieldset>

      <fieldset>
        <input type="submit" class="btn primary" value="Approve"/>
        <?php echo link_to('Cancel', 'approve_deal/index', 'class=btn') ?>
      </fieldset>

    </form>
  </div>
</div>

<script type="text/javascript">
$(function() {
  $('#deal_commission_percentage').change(function(el) {
    $('#deal_commission_pot').val(Math.round(($('#deal_price').val() * ($('#deal_commission_percentage').val() / 100))*100)/100);
    $('#deal_commission_per_unit').val($('#deal_commission_pot').val() / $('#deal_target_quantity').val());

    $('#deal_commission_pot_dummy').val($('#deal_commission_pot').val());
    $('#deal_commission_per_unit_dummy').val($('#deal_commission_per_unit').val());
  });
});
</script>



