<?php use_helper('I18N', 'Date') ?>

<div id="sf_admin_container">
  <h1><?php echo __("Domain Settings"); ?></h1>

  <div class="clearfix content-header-box" id="filter">
    <form name="search" class="left" id="search" action="<?php url_for("domain_settings/index"); ?>">
      <div class="form-area" style="float:left;">
        <label for="search-field"><?php echo __("Add/Edit&nbsp;a&nbsp;Domain"); ?></label>
        <input type="text" name="search" id="search-field" value="<?php echo $search; ?>" class="tooltip" title="Search for the domain you want to add/edit" placeholder="Search for the domain you want to add/edit" />
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
          <th><?php echo __("Enable Ads?"); ?></th>
          <th><?php echo __("Ad muting (time in minutes)"); ?></th>
          <th><?php echo __("Display Type"); ?></th>
        </tr>
      </thead>

      <tbody>
				<?php foreach($domain_settings as $ds) { ?>
				<tr>
        	<td><?php echo link_to($ds->getDomain(), "domain_settings/edit", array('query_string' => 'id='.$ds->getId())); ?></td>
          <td><?php echo $ds->getEnableAds() ? __("yes"): __("no"); ?></td>
					<td><?php if (is_numeric($ds->getMute())) {
						echo $ds->getMute() . " " . __("Minutes");
					} else {
						echo __("not set (default value)");
					} ?></td>
          <td><?php echo $ds->getAdDisplayer(); ?></td>
        </tr>
				<?php } ?>
      </tbody>
    </table>
		
		<ul class="sf_admin_actions">
			<li class="sf_admin_action_list"><a href="<?php echo url_for("domain_settings/create"); ?>">Create new Settings</a></li>
		</ul>
  </div>
</div>