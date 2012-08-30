<?php if(!isset($lSearchTag)) $lSearchTag = '' ?>
  <div class="clearfix" style="border-top:1px black solid;border-bottom:1px black solid;margin-top:10px;padding:10px;background-color:#eee">
    <form action="<?php echo url_for('trans_unit/look_for_wildcard'); ?>" method="POST">
      <span class="bold">Search for wildcard</span>&nbsp;
      <input type="text" id='wildcard' name="wildcard" value="<?php echo $lSearchTag;?>" />
      <input type="submit" name='Search'/ >
    </form>
  </div>