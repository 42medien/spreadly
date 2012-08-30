  <li class="tooltip">
    <a href="#" class="<?php echo $identity->getCommunity()->getCommunity(); ?>"><span><?php echo $identity->getName(); ?></span></a>
    <input type="checkbox" name="like[oiids][]" class="likecheckbox" value="<?php echo $identity->getId(); ?>" checked="checked" />
  </li>