<?php use_helper('Date', 'DomainProfiles') ?>
<div class="content-header-box" id="creat-deal-box">
	<div class="content-box-head">
		<h3><?php echo __('+ Select a profile')?></h3>
	</div>
	<div class="content-box-body" id="claiming-profile-content">

		<table id="domain_profiles_table" cellspacing="0" class="full sheet">
		  <thead>
		    <tr>
		    	<th style="text-align: left;"><?php echo __('Rank'); ?></th>
		      <th style="text-align: left;"><?php echo __('Website');?></th>
		      <th></th>
		      <th></th>
		      <th></th>
		      <th></th>
		    </tr>
		  </thead>
		  <tbody>
		    <?php if(count($pVerifiedDomains) > 0) { ?>
		    	<?php $i = 1;?>
					<?php foreach($pVerifiedDomains as $lDomain) { ?>
					<tr class="<?php echo $i%2==0 ? 'odd' : 'even' ?>">
						<td><?php echo $i; ?></td>
		        <td>
							<?php echo link_to($lDomain->getUrl(), '@analytics?host_id='.$lDomain->getId()); ?>
		        </td>
		        <td></td>
		        <td></td>
		        <td></td>
		        <td></td>
		      </tr>
			    <?php $i++; } ?>
		    <?php } else { ?>
		      <tr id="no-claim">
		        <td colspan="5">
		          <h3><?php echo __('No websites claimed');?></h3>
		        </td>
		      </tr>
		    <?php } ?>
		  </tbody>
		  <tfoot>
		    <tr>
		      <td colspan="7">&nbsp;</td>
		    </tr>
		  </tfoot>
		</table>
	</div>
</div>

