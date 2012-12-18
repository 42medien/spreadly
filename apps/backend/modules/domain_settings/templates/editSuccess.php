<div id="content" class="clearfix">
	<div id="sf_admin_container">
		<h1>Edit DomainSettings</h1>
		<div id="sf_admin_header"> </div>
		<div id="sf_admin_content">
			<div class="sf_admin_form">
				<form method="post" action="<?php echo url_for("domain_settings/edit"); ?>">
					<input type="hidden" name="domain_settings[id]" value="<?php echo $domain_setting->getId(); ?>" id="domain_settings_id">
					
					<fieldset id="sf_fieldset_none">
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_domain">Domain</label>
						    <div class="content">
									<input type="text" name="domain_settings[domain]" value="<?php echo $domain_setting->getDomain(); ?>" id="domain_settings_domain" disabled="disabled">
								</div>
							</div>
						</div>
						
						<!-- disable ads -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_disable_ads">Disable Ads?</label>
						    <div class="content">
									<input type="checkbox" name="domain_settings[disable_ads]" id="main_settings_disable_ads"<?php echo $domain_setting->getDisableAds() ? " checked='checked'": "" ?>>
								</div>
							</div>
						</div>
            
						<!-- disable ads -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_ad_displayer">Show Ads on "hover"</label>
						    <div class="content">
									<input type="checkbox" name="domain_settings[ad_displayer]" id="domain_settings_ad_displayer"<?php echo $domain_setting->getAdDisplayer() == "hover" ? " checked='checked'": "" ?>>
								</div>
							</div>
						</div>
						
						<!-- muting -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_mute">Mute</label>
						    <div class="content">
									<input type="text" name="domain_settings[mute]" value="<?php echo $domain_setting->getMute(); ?>" id="domain_settings_mute">
								</div>
							</div>
						</div>
					</fieldset>
					
					<ul class="sf_admin_actions">
						<li class="sf_admin_action_list"><a href="<?php echo url_for("domain_settings/index"); ?>">Back to list</a></li>
            <li class="sf_admin_action_list"><a href="<?php echo url_for("domain_settings/delete?id=".$domain_setting->getId()); ?>">Delete</a></li>
						<li class="sf_admin_action_save"><input type="submit" value="Save"></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
</div>