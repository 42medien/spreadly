    <div class="whtboxtopwide spreadsel_box">
      <div class="rcor clearfix">
        <div class="alignleft checklist">
          <ul class="clearfix">
            <?php foreach($pIdentities as $lIdentity) {?>
            <li>
              <input type="checkbox" name="like[oiids][]" class="likecheckbox" value="<?php echo $lIdentity->getId(); ?>" <?php if ($lIdentity->getSocialPublishingEnabled()) { echo 'checked="checked"'; }  ?> /><?php echo image_tag("/img/".$lIdentity->getCommunity()->getCommunity()."-favicon.gif", array("alt" => $lIdentity->getName(), "title" => $lIdentity->getName())); ?>
            </li>
            <?php } ?>
          </ul>
        </div>
        <div class="alignright comment">
          <span><?php echo __("Preview for Facebook"); ?></span><br>
          <?php echo __("(Your entry may look different in other services)"); ?>
        </div>
      </div>
    </div>