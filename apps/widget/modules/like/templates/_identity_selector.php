<?php if ($identity->isFlattr() && (!$domain_profile || !$domain_profile->getFlattrAccount())) { ?>
<li class="B" title="<?php echo __("Domain doesn't support flattr"); ?>">
  <input type="checkbox" id="o<?php echo $identity->getId(); ?>" name="like[oiids][]" value="" disabled="disabled" />
  <label for="o<?php echo $identity->getId(); ?>"><?php echo image_tag("/img/".$identity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $identity->getName(), "title" => $identity->getName())); ?>
    <?php echo link_to('x', 'settings/delete_oi?id='.$identity->getId() , array('title' => __('Delete profile'), 'class' => 'delete-oi-link', 'id' => 'delete-oi-'.$identity->getId()))?>
  </label>
</li>
<?php } elseif ($identity->getActive()) { ?>
<li class="B">
  <input type="checkbox" id="o<?php echo $identity->getId(); ?>" name="like[oiids][]" value="<?php echo $identity->getId(); ?>" <?php if ($identity->getSocialPublishingEnabled()) { echo 'checked="checked"'; }  ?> />
  <label for="o<?php echo $identity->getId(); ?>"><?php echo image_tag("/img/".$identity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $identity->getName(), "title" => $identity->getName())); ?>
    <?php echo link_to('x', 'settings/delete_oi?id='.$identity->getId() , array('title' => __('Delete profile'), 'class' => 'delete-oi-link', 'id' => 'delete-oi-'.$identity->getId()))?>
  </label>
</li>
<?php } else { ?>
<li class="B" onclick="window.open('<?php echo url_for("@signinto?service=".$identity->getCommunity()->getCommunity()); ?>', 'auth_popup', 'width=580,height=450,scrollbars=no,toolbar=no,status=no,resizable=no,menubar=no,location=0,directories=no,top=150,left=150'); return false;">
  <input type="checkbox" id="o<?php echo $identity->getId(); ?>" name="like[oiids][]" value="" disabled="disabled" />
  <label for="o<?php echo $identity->getId(); ?>"><?php echo image_tag("/img/".$identity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $identity->getName(), "title" => $identity->getName())); ?>
    <?php echo link_to('x', 'settings/delete_oi?id='.$identity->getId() , array('title' => __('Delete profile'), 'class' => 'delete-oi-link', 'id' => 'delete-oi-'.$identity->getId()))?>
  </label>
</li>
<?php } ?>