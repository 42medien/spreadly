<?php include_partial('deals/breadcrumb'); ?>


<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_billing?did='.$pDealId); ?>" name="create_deal_form" method="POST">

	<div class="dealwidebox alignright">
		<!-- screen von deal-like -->
	</div>
	<div class="createbtnbox alignleft">
		<h2 class="btntitle"><?php echo __('Step 3: Enter your payment method')?></h2>
		<ul class="btnformlist">
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['payment_method']['company']->renderLabel(); ?></strong><span><?php echo $pForm['payment_method']['company']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['payment_method']['company']->render(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['payment_method']['contact_name']->renderLabel(); ?></strong><span><?php echo $pForm['payment_method']['contact_name']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['payment_method']['contact_name']->render(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['payment_method']['address']->renderLabel(); ?></strong><span><?php echo $pForm['payment_method']['address']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['payment_method']['address']->render(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['payment_method']['zip']->renderLabel(); ?></strong><span><?php echo $pForm['payment_method']['zip']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['payment_method']['zip']->render(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['payment_method']['city']->renderLabel(); ?></strong><span><?php echo $pForm['payment_method']['city']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['payment_method']['city']->render(); ?>
	      </span>
	    </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['tos_accepted']->renderLabel(); ?></strong><span><?php echo $pForm['tos_accepted']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['tos_accepted']->render(); ?>
	      </span>
	    </li>
		</ul>
		<input type="submit" id="create_deal_button" />
	</div>
</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>
