<?php
  $lSessionUser = sfContext::getInstance()->getUser();
  $lUserCulture = $lSessionUser->getCulture();
?>

<table id="likebutton-form-table" cellpadding="0" cellspacing="0">
  <tr>
    <td><input type="text" name="likebutton[url]" id="likebutton_url" value="http://" /></td>
    <td class="right_side"><label for="likebutton_url"><?php echo __('LABEL_URL', null, 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td>
      <select name="likebutton[l]" id="likebutton_l">
        <option value="de" selected="selected"><?php echo __('SELECT_LANGUAGE_DE', null, 'configurator'); ?></option>
        <option value="en"><?php echo __('SELECT_LANGUAGE_EN', null, 'configurator'); ?></option>
      </select>   
    </td>
    <td class="right_side"><label for="likebutton_l"><?php echo __('LABEL_LANGUAGE', null, 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td id="select-type">
      <?php include_partial('likebutton/select_type', array('pCulture' => $lUserCulture)) ?>
    </td>
    <td class="right_side"><label for="likebutton_t"><?php echo __('SELECT_WORDING_DEFAULT', null, 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td><input type="text" name="likebutton[w]" id="likebutton_w" value="<?php echo __('VALUE_WIDTH', null, 'configurator'); ?>" /></td>
    <td class="right_side"><label id="width_label" for="likebutton_w"><?php echo __('LABEL_WIDTH', array('%1' => '<span id="width_value">325</span>'), 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td><input type="text" name="likebutton[fc]" id="likebutton_fc" value="#000000" /></td>
    <td class="right_side"><label for="likebutton_fc"><?php echo __('LABEL_FONTCOLOR', null, 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td><input type="checkbox" name="likebutton[so]" id="likebutton_so" /><label for="likebutton_so"><?php echo __('Add social features'); ?></label></td>
    <td class="right_side"><label for="likebutton_so"><?php echo __('shows small images and names of your friends that share the same website'); ?></label></td>
  </tr>  
  <tr>
    <td><input type="checkbox" name="likebutton[bt]" id="likebutton_bt" /><label for="likebutton_bt"><?php echo __('HELP_DISLIKE_OPTION', null, 'configurator'); ?></label></td>
    <td class="right_side"><label for="likebutton_bt"><?php echo __('LABEL_DISLIKE_OPTION', null, 'configurator'); ?></label></td>
  </tr>
  <tr>
    <td><input type="checkbox" name="likebutton[sh]" id="likebutton_sh" /><label for="likebutton_sh"><?php echo __('Short version'); ?></label></td>
    <td class="right_side"><label for="likebutton_sh"><?php echo __('Default: Common big version'); ?></label></td>
  </tr>
  <tr>
    <td><input type="text" name="likebutton[email]" id="likebutton_email" value="<?php echo __('VALUE_EMAIL', null, 'configurator'); ?>" /></td>
    <td class="right_side"><label for="likebutton_email"><?php echo __('LABEL_EMAIL', null, 'configurator'); ?></label></td>
  </tr>
</table>
