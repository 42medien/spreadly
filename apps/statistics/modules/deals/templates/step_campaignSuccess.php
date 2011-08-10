<?php include_partial('deals/breadcrumb', array('pDeal' => $pDeal)); ?>


<?php slot('content') ?>
<form action="<?php echo url_for('deals/step_campaign?did='.$pDealId); ?>" name="create_deal_form" id="deal_form" method="POST">
	<?php //echo $pForm['_csrf_token']->render(); ?>

	<div class="createbtnbox alignleft">
  	<h2 class="btntitle"><?php echo __('Step 1: Create your Campaign')?></h2>
    <ul class="btnformlist">
    	<li class="clearfix">
      	<div class="btnwording alignleft">
        	<strong><?php echo $pForm['name']->renderLabel(); ?></strong><span><?php echo __('Name of the new deal'); ?></span>
        </div>
        <label class="textfield-wht">
        	<span>
          	<?php echo $pForm['name']->render(array('class' => 'wd390')); ?>
          </span>
        </label>
        <div class="content-error-box clearfix"><?php echo $pForm['name']->renderError(); ?></div>
      </li>
	    <li class="clearfix">
	    	<div class="btnwording alignleft">
	      	<strong><?php echo $pForm['target_quantity']->renderLabel(); ?></strong><span><?php echo $pForm['target_quantity']->renderError(); ?></span>
	      </div>
	      <span>
	      	<?php echo $pForm['target_quantity']->render(); ?>
	      </span>
	    </li>
    </ul>
		<input type="submit" id="create_deal_button" class="alignright" />
  </div>
	<div class="alignleft" id="create-deal-helptext">
		<h2 class="btntitle"><?php echo __('Willkommen bei den Spreadly-Deals'); ?></h2>
		<p><?php echo __('Weit hinten, hinter den Wortbergen, fern der Länder Vokalien und Konsonantien leben die Blindtexte. Abgeschieden wohnen Sie in Buchstabhausen an der Küste des Semantik, eines großen Sprachozeans. Ein kleines Bächlein namens Duden fließt durch ihren Ort und versorgt sie mit den nötigen Regelialien. Es ist ein paradiesmatisches Land, in dem einem gebratene Satzteile in den Mund fliegen. Nicht einmal von der allmächtigen Interpunktion werden die Blindtexte beherrscht – ein geradezu unorthographisches Leben. Eines Tages aber beschloß eine kleine Zeile Blindtext, ihr Name war Lorem Ipsum, hinaus zu gehen in die weite Grammatik. Der große Oxmox riet ihr davon ab, da es dort wimmele von bösen Kommata, wilden Fragezeichen und hinterhältigen Semikoli, doch das Blindtextchen ließ sich nicht beirren. Es packte seine sieben Versalien, schob sich sein Initial in den Gürtel und machte sich auf den Weg.'); ?></p>
	</div>
</form>


<?php end_slot(); ?>
<?php include_partial('global/graybox'); ?>

