<div id="content" class="clearfix">
	<div id="sf_admin_container">
		<h1>Edit Advertisement</h1>
		<div id="sf_admin_header"> </div>
		<div id="sf_admin_content">
			<div class="sf_admin_form">
				<form method="post" action="<?php echo url_for("advertisement/edit"); ?>">
					<input type="hidden" name="ad[id]" value="<?php echo $ad->getId(); ?>" id="domain_settings_id">
					
					<fieldset id="sf_fieldset_none">
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="ad_domains">Domains</label>
						    <div class="content">
									<textarea name="ad[domains]" id="ad_domains" rows="10" cols="100"><?php echo $ad->getDomainsAsString(); ?></textarea>
								</div>
							</div>
						</div>
						
						<!-- disable ads -->
						<div class="sf_admin_form_row sf_admin_text sf_admin_form_field_url">
							<div>
						  	<label for="ad_ad_code">The Ad-Code</label>
						    <div class="content">
									<textarea name="ad[ad_code]" id="ad_ad_code" rows="10" cols="100"><?php echo $ad->getAdCode(); ?></textarea>
								</div>
							</div>
						</div>

					</fieldset>
					
					<ul class="sf_admin_actions">
						<li class="sf_admin_action_list"><a href="<?php echo url_for("advertisement/index"); ?>">Back to list</a></li>
						<li class="sf_admin_action_save"><input type="submit" value="Save"></li>
					</ul>
				</form>
			</div>
		</div>
	</div>
</div>