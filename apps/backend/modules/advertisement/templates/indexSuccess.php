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
          <th><?php echo __("Domains"); ?></th>
          <th><?php echo __("Ad Code"); ?></th>
          <th><?php echo __("Last Update"); ?></th>
        </tr>
      </thead>

      <tbody>
				<?php foreach($ads as $ad) { ?>
				<tr>
        	<td><?php echo link_to($ad->getDomainsAsString(), "advertisement/edit", array('query_string' => 'id='.$ad->getId())); ?></td>
          <td><?php echo htmlentities($ad->getAdCode()); ?></td>
          <td><?php echo date("c", $ad->getUpdatedAt()); ?></td>
        </tr>
				<?php } ?>
      </tbody>
    </table>
		
		<ul class="sf_admin_actions">
			<li class="sf_admin_action_list"><a href="<?php echo url_for("advertisement/create"); ?>">Create new Settings</a></li>
		</ul>
  </div>
</div>