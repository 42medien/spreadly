  <li class="tooltip">
    <input type="checkbox" name="like[oiids][]" class="likecheckbox" value="<?php echo $identity->getId(); ?>" <?php if ($identity->getSocialPublishingEnabled()) { echo 'checked="checked"'; }  ?> id="id-<?php echo $identity->getId(); ?>" />
    <label class="<?php echo $identity->getCommunity()->getCommunity(); ?><?php if ($identity->getSocialPublishingEnabled()) { echo ' checked'; }  ?>" for="id-<?php echo $identity->getId(); ?>"><span><?php echo $identity->getName(); ?></span></label>
  </li>