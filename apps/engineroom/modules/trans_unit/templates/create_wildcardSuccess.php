<?php if(!isset($lSearchTag)) $lSearchTag = '' ?>
<div id="sf_admin_header">
  <?php include_partial('trans_unit/i18n_header', array('lSearchTag' => $lSearchTag)); ?>
</div>

<?php if($lCreateAfterEmptySearch) { ?>
  <h2>The wildcard <?php echo $lWildcardName; ?> does not exist yet. You can create it here!</h2>
<?php } ?>

<h3>Create new wildcard</h3>

<p>Please insert the name of your new wildcard and at least the english translation.</p>

<form action="<?php echo url_for('trans_unit/create_wildcard'); ?>" method="POST">
  <div class="clearfix" style="border:1px black solid;margin:20px 10px 20px 0;padding:10px;background-color:#ddd">
	  <div class="clearfix">
	    <div style="float:left;width:200px;">
	      <span class="bold">Wildcard name:</span>
	    </div>
	    <div style="float:left;">
	      <input type="text" name='wildcard_name' id='wildcard_name' value="<?php echo $lWildcardName;?>" style='width:1000px' />
	    </div>
	  </div>

	  <div class="clearfix" style="margin:20px 0 0 0;">
	    <div style="float:left;width:200px;">
	      <span class="bold">Catalogue:</span>
	    </div>
	    <div style="float:left;">
	      New wildcards are saved in the <span class="bold">messages.$culture (e.g. messages.en)</span> catalogue by default. (For Developers: Please consider this feature during your implementation!)
	    </div>
	  </div>

	  <div class="clearfix" style="margin:20px 0 0 0;">
	    <div style="float:left;width:500px;">
        <span class="bold">In welchen Sprachen muss die Wildcard noch übersetzt werden?</span>
      </div>
      <div style="float:left;">
		    <?php foreach(LanguageTable::getAllLanguages(false) as $lCulture) { ?>
		      <label style="padding-left:20px;" for="to-translate-<?php echo $lCulture; ?>"><?php echo image_tag('/img/icons/flags/'.$lCulture.'.gif'); ?></label>
		      <input type="checkbox" name="to_translate[<?php echo $lCulture; ?>]" id="to-translate-<?php echo $lCulture; ?>" <?php echo ($lCulture != 'de' && $lCulture != 'en' ? 'checked' : ''); ?> />
		    <?php } ?>
		  </div>
	  </div>
  </div>




  <?php foreach (LanguageTable::getAllLanguages(false) as $lCulture) { ?>
    <div class="clearfix" style="border:1px #ccc solid;margin:0 10px 10px 0;padding:10px;">

      <div class="clearfix">
	      <div style="float:left;width:200px;">
	        <span class="bold">Language:</span> <?php echo image_tag('/img/icons/flags/'.$lCulture.'.gif').' '.$lCulture; ?>
	      </div>
	      <div style="float:left;">
	        <textarea class="translation-textarea" id="wildcard[<?php echo $lCulture ?>][target]" name="wildcard[<?php echo $lCulture ?>][target]"></textarea>
	      </div>
      </div>

<?php /*
      <div class="clearfix">
	      <div style="float:left;width:200px;">
	        <span class="bold">Comment/Description:</span>
	      </div>
	      <div style="float:left;">
	        <input type="text" name="wildcard['.$lCulture.'][comment]
	        <?php echo input_tag('wildcard['.$lCulture.'][comment]', null, array('style' => 'width:1000px')); ?>
	      </div>
	    </div>
*/ ?>
    </div>
  <?php } ?>

<input type="submit" name="Save wildcard" />
</form>