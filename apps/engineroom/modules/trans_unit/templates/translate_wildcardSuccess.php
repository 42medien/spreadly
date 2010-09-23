<?php if(!isset($lSearchTag)) $lSearchTag = '' ?>
<div id="sf_admin_header">
  <?php include_partial('trans_unit/i18n_header', array('lSearchTag' => $lSearchTag)); ?>
</div>

<?php $lWildcardObjects =  $lWildcardObjects->getRawValue(); ?>
<h3>Wildcard: <?php echo $lWildcardObjects[0]->getSource(); ?></h3>


<form action="<?php echo url_for('i18n_texts/save_translation'); ?>" method="POST" id="wildcard-translation-form">
  <?php foreach($lWildcardObjects as $lWildcard) {    ?>
	  <div class="clearfix" style="width:1000px;border:1px black solid;margin:0 10px 20px 0;padding:10px;">
      <?php $lCatalogue = $lWildcard->getCatalogue(); ?>
      <?php $lCulture = $lCatalogue->getTargetLang(); ?>
      <div style="float:left;">
        <span class="bold">Language</span> <?php echo image_tag('/img/icons/flags/'.$lCulture.'.gif').' '.$lCulture; ?>
      </div>
      <div style="float:right;">
        <span class="bold">Catalogue</span> <?php echo $lCatalogue->getName(); ?>
      </div>
      <br/><br/>
      <span class="bold">Translation</span>
		  <textarea class="translation-textarea" id="wildcard[<?php echo $lWildcard->getId();?>][target]" name="wildcard[<?php echo $lWildcard->getId()?>][target]" ><?php echo $lWildcard->getTarget(); ?></textarea>

      <br/>

	    <input type="hidden" name="wildcard[<?php echo $lWildcard->getId(); ?>][id]'" id="wildcard_id" />
      <?php  //echo input_hidden_tag('wildcard_id', $lWildcard->getId(), array('name' => 'wildcard['.$lWildcard->getId().'][id]')); ?>
		</div>
  <?php } ?>
  <?php // echo input_hidden_tag('referer', $lReferer); ?>

  <div class="clearfix" style="margin:20px 0 20px 0;">
	  <div style="float:left;width:425px;">
	    <span class="bold">In welchen Sprachen muss die Wildcard noch übersetzt werden?</span>
	  </div>
	  <div style="float:left;">
	    <?php foreach(LanguageTable::getAllLanguages(true) as $lCulture) { ?>
	      <label style="padding-left:20px;" for="to-translate-<?php echo $lCulture; ?>"><?php echo image_tag('/img/icons/flags/'.$lCulture.'.gif'); ?></label>
	      <input type="checkbox" name="to_translate[<?php echo $lCulture; ?>]" id="to-translate-<?php echo $lCulture; ?>" <?php echo ($lCulture != 'de' && $lCulture != 'en' ? 'checked' : ''); ?> />
	    <?php } ?>
	  </div>
	</div>

  <a href="#" class="button green small" onclick="document.getElementById('wildcard-translation-form').submit();return false;">Save</a>
  <?php echo link_to('Cancel', $lReferer, array('class' => 'button green small')); ?>

</form>