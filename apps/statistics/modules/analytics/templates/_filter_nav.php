<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('URLs'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_urls', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_urls', array('query_string' => 'com=facebook&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_urls', array('query_string' => 'com=twitter&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_urls', array('query_string' => 'com=linkedin&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_urls', array('query_string' => 'com=google&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo.'&url='.$pUrl, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Activities'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_content', array('query_string' => 'com=all&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Reach'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_content', array('query_string' => 'com=all&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=activities_with_clickbacks&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Demographics'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('Age'), '@get_analytics_content', array('query_string' => 'com=all&type=age_distribution&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Gender'), '@get_analytics_content', array('query_string' => 'com=all&type=gender_distribution&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Relationship'), '@get_analytics_content', array('query_string' => 'com=all&type=relationship_status&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>