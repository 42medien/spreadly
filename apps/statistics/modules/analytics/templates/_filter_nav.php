<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Activities'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_activities', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_activities', array('query_string' => 'com=facebook&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '/'); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '/'); ?></li>
			<li><?php echo link_to(__('Buzz'), '/'); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Range'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('All'), '@get_analytics_range', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Facebook'), '@get_analytics_range', array('query_string' => 'com=facebook&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Twitter'), '/'); ?></li>
			<li><?php echo link_to(__('LinkedIn'), '/'); ?></li>
			<li><?php echo link_to(__('Buzz'), '/'); ?></li>
		</ul>
	</li>
</ul>

<ul class="analytics-filter-list clearfix">
	<li>
		<?php echo __('Demographics'); ?>
		<ul class="clearfix">
			<li><?php echo link_to(__('Age'), '@get_analytics_age', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Gender'), '@get_analytics_gender', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
			<li><?php echo link_to(__('Relationship'), '@get_analytics_relations', array('query_string' => 'com=all&host_id='.$pHostId.'&date-from='.$pFrom.'&date-to='.$pTo, 'class' => 'analytix-filter-link')); ?></li>
		</ul>
	</li>
</ul>