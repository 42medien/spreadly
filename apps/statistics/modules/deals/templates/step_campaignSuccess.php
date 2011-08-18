<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>


<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_campaign?did='.$pDealId); ?>" name="create_deal_form" id="deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>

	<div class="createbtnbox alignleft">
  	<h2 class="btntitle"><?php echo __('Schritt 1: Kampagne anlegen')?></h2>
    <ul class="btnformlist">
    	<li class="clearfix">
      	<div class="btnwording alignleft">
        	<strong><?php echo $pForm['name']->renderLabel(); ?></strong><span><?php echo __('Geben Sie Ihrer Kampagne einen Namen, damit Sie sie von eventuellen weiteren unterscheiden können. Dieser Name erscheint nicht öffentlich.'); ?></span>
        </div>
        <label class="textfield-wht">
        	<span>
          	<?php echo $pForm['name']->render(array('class' => 'wd320')); ?>
          </span>
        </label>
        <div class="content-error-box clearfix"><?php echo $pForm['name']->renderError(); ?></div>
      </li>
	    <li class="clearfix" id="select-target-quantity">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['target_quantity']->renderLabel(); ?></strong><span><?php echo __('Sie buchen für Ihre Kampagne eine bestimmte Anzahl von Likes. Bitte wählen Sie:'); ?></span>
	      	<span><?php echo $pForm['target_quantity']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['target_quantity']->render(); ?>
	      </span>
	    </li>
    </ul>
		<input type="submit" id="create_deal_button" value="<?php echo __('Weiter'); ?>" class="alignright button" />
  </div>
	<div class="alignleft create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Deal Kampagnen von Spreadly'); ?></h2>
		<p><?php echo __('Sie haben eine gute Entscheidung getroffen, denn Sie zahlen nur für die tatsächlich erzielte Reichweite Ihrer Kampagne.<br/> Ihr Deal erscheint für den Teilnehmer als Angebot im Like-Popup von Spreadly.<br/> Sie erreichen so eine internetaffine Zielgruppe, die gern Inhalte über verschiedene Social Media Kanäle verbreitet.<br/> Gestalten Sie Ihr Angebot so reizvoll wie möglich, damit sich schnell der von Ihnen gewünschte Erfolg einstellt. In den Statistiken können Sie jederzeit die Resonanz Ihrer Kampagne prüfen.'); ?></p>
	</div>
</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

