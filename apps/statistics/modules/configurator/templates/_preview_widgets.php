<?php

  if(!isset($pWidgetType)) $pWidgetType = '';
  if(!isset($pLang)) $pLang = '';
  if(!isset($pWidth)) $pWidth = '';
  if(!isset($pType)) $pType = '';
  if(!isset($pFontColor)) $pFontColor = '';

?>
<div class="group radiobtn_list alignleft">
	<label for="radio1">&nbsp;</label><input id="radio1" type="radio" name="likebutton[wt]" value="short" class="widget-radio" checked="checked"/>
	<label for="radio2">&nbsp;</label><input id="radio2" type="radio" name="likebutton[wt]" value="stand_social" class="widget-radio"/>
</div>
<div class="status_list alignleft">
	<ul>
		<li><?php include_partial('configurator/widget_like', array('pUrl' => $pUrl, 'pLang'=>$pLang)); ?></li>
		<li class="last"><?php include_partial('configurator/widget_full', array('pUrl' => $pUrl, 'pLang'=>$pLang)); ?></li>
	</ul>
</div>
