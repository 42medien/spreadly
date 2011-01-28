<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('URLs'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_urls', array('query_string' => 'com=all&type=url_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_urls', array('query_string' => 'com=facebook&type=url_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_urls', array('query_string' => 'com=twitter&type=url_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_urls', array('query_string' => 'com=linkedin&type=url_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_urls', array('query_string' => 'com=google&type=url_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Activities'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_content', array('query_string' => 'com=all&type=domain_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=domain_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=domain_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=domain_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=domain_activities&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Reach'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_content', array('query_string' => 'com=all&type=reach&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=reach&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=reach&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=reach&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=reach&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Demographics'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('Age'), '@get_analytics_content', array('query_string' => 'com=all&type=age&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Gender'), '@get_analytics_content', array('query_string' => 'com=all&type=gender&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Relationship'), '@get_analytics_content', array('query_string' => 'com=all&type=relationship&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>