<?php use_helper('I18N', 'Date') ?>

<div id="sf_admin_container">
  <h1><?php echo __("Domain Settings"); ?></h1>

  <div class="clearfix content-header-box" id="filter">
    <form name="search" class="left" id="search" action="/backend.php/domain_settings/monthly">
      <div class="form-area" style="float:left;">
        <label for="search-field"><?php echo __("Add/Edit&nbsp;a&nbsp;Domain"); ?></label>
        <input type="text" name="month" id="search-field" value="" class="tooltip" title="Search for the domain you want to add/edit" placeholder="Search for the domain you want to add/edit" />
      </div>
      <div class="form-area" style="float:left;margin-top:20px; margin-left:15px;">
        <input type="submit" value="<?php echo __("Search"); ?>" />
      </div>
    </form>
  </div>
	
	<!-- Content Table -->
	
  <div class="sf_admin_list">
    <table class="full sheet" id="monthly_table">
      <thead>
        <tr>
          <th><?php echo __("Domain"); ?></th>
          <th><?php echo __("Disable Ads?"); ?></th>
          <th><?php echo __("Ad muting (time in minutes)"); ?></th>
        </tr>
      </thead>

      <tbody>
				<?php foreach($domain_settings as $ds) { ?>
				<tr>
        	<td><?php echo $ds->getDomain(); ?></td>
          <td><?php echo $ds->getDisableAds() ? __("yes"): __("no"); ?></td>
					<td><?php if (is_numeric($ds->getMute())) {
						echo $ds->getMute() . " " . __("Minutes");
					} else {
						echo __("not set (default value)");
					} ?></td>
          
        </tr>
				<?php } ?>
      </tbody>
  
      <tfoot>
        <tr>
          <td colspan="3">
     			 	pager
          </td>
        </tr>
      </tfoot>
    </table>
  </div>
</div>