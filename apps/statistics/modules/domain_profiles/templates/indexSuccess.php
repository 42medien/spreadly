			<section class="content-publish">
				<section class="container_12">
					<div class="page-titlecontent">
						<h2>Claim your sites</h2>
						<p>Please confirm that you are the owner oder admin of the website. The verifictaion of your domain ownership is required for activating the deal function of the
	Spreadly button as well as the statistics section. Please do not hesitate to contact us if any problems occur. <a href="mailto:info@spreadly.com" title="info@spreadly.com">info@spreadly.com</a></p>
					</div>
					<div class="yiidtable-publish">


					<div id="add-domain-profiles">
  					<?php include_partial('domain_profiles/form', array('form'=> $form)); ?>
  				</div>

					<?php include_partial('domain_profiles/domain_profiles_table', array('domain_profiles' => $domain_profiles)); ?>


					</div>

				<?php include_partial('global/spreadly_references');?>
				</section>
			</section>