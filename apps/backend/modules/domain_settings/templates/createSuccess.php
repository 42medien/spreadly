<div id="content" class="clearfix">
	<div id="sf_admin_container">
		<h1>Edit DomainSettings</h1>
		<div id="sf_admin_header"> </div>
		<div id="sf_admin_content">
			<div class="sf_admin_form">
				<form method="post" action="<?php echo url_for("domain_settings/create"); ?>">
					<fieldset id="sf_fieldset_none">
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_domain">Domain</label>
						    <div class="content">
									<input type="text" name="domain_settings[domain]" id="domain_settings_domain" placeholder="www.spreadly.com">
								</div>
								<div class="help">OHNE "http://" !!!</div>
							</div>
						</div>
						
						<!-- disable ads -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_disable_ads">Disable Ads?</label>
						    <div class="content">
									<input type="checkbox" name="domain_settings[disable_ads]" id="main_settings_disable_ads">
								</div>
							</div>
						</div>
            
						<!-- disable ads -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_ad_displayer">Show Ads on "hover"</label>
						    <div class="content">
									<input type="checkbox" name="domain_settings[ad_displayer]" id="domain_settings_ad_displayer">
								</div>
							</div>
						</div>
						
						<!-- muting -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="domain_settings_mute">Mute</label>
						    <div class="content">
									<input type="text" name="domain_settings[mute]" id="domain_settings_mute" placeholder="60">
								</div>
								<div class="help">Wie lange soll der Layer ausgeblendet bleiben? Zeit in Minuten!</div>
							</div>
						</div>
					</fieldset>
					
					<ul class="sf_admin_actions">
						<li class="sf_admin_action_list"><a href="<?php echo url_for("domain_settings/index"); ?>">Back to list</a></li>
						<li class="sf_admin_action_save"><input type="submit" value="Save"></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
</div>