<!--Narrow nav column -->
<div class="narrowcolumn alignleft">
	<div>
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
				<div class="graybox clearfix">
        	<dl id="subnavigation">
          	<dd>
            	<h3><?php echo __('URLs'); ?></h3>
              <ul>
              	<li class="first"><?php echo link_to(image_tag('/img/gesamt-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Gesamt'), 'title'=>__('Gesamt'))).__('Gesamt'), '@get_analytics_content', array('query_string' => 'com=all&type=url_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
	              <li><?php echo link_to(image_tag('/img/facebook-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Facebook', 'title'=>'Facebook')).__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=url_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/twitter-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Twitter', 'title'=>'Twitter')).__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=url_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/in-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'LinkedIn', 'title'=>'LinkedIn')).__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=url_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li class="last"><?php echo link_to(image_tag('/img/buzz-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Google Buzz', 'title'=>'Google Buzz')).__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=url_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
              </ul>
            </dd>
            <dd>
            	<h3><?php echo __('Activities'); ?></h3>
            	<ul>
              	<li class="first"><?php echo link_to(image_tag('/img/gesamt-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Gesamt'), 'title'=>__('Gesamt'))).__('Gesamt'), '@get_analytics_content', array('query_string' => 'com=all&type=domain_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
	              <li><?php echo link_to(image_tag('/img/facebook-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Facebook', 'title'=>'Facebook')).__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=domain_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/twitter-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Twitter', 'title'=>'Twitter')).__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=domain_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/in-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'LinkedIn', 'title'=>'LinkedIn')).__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=domain_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li class="last"><?php echo link_to(image_tag('/img/buzz-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Google Buzz', 'title'=>'Google Buzz')).__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=domain_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
            	</ul>
          	</dd>
            <dd>
            	<h3><?php echo __('Reach'); ?></h3>
              <ul>
              	<li class="first"><?php echo link_to(image_tag('/img/gesamt-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Gesamt'), 'title'=>__('Gesamt'))).__('Gesamt'), '@get_analytics_content', array('query_string' => 'com=all&type=reach_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
	              <li><?php echo link_to(image_tag('/img/facebook-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Facebook', 'title'=>'Facebook')).__('Facebook'), '@get_analytics_content', array('query_string' => 'com=facebook&type=reach_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/twitter-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Twitter', 'title'=>'Twitter')).__('Twitter'), '@get_analytics_content', array('query_string' => 'com=twitter&type=reach_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li><?php echo link_to(image_tag('/img/in-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'LinkedIn', 'title'=>'LinkedIn')).__('LinkedIn'), '@get_analytics_content', array('query_string' => 'com=linkedin&type=reach_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
                <li class="last"><?php echo link_to(image_tag('/img/buzz-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>'Google Buzz', 'title'=>'Google Buzz')).__('Buzz'), '@get_analytics_content', array('query_string' => 'com=google&type=reach_activities&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&url='.$pUrl.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
              </ul>
            </dd>
            <dd class="last">
            	<h3><?php echo __('Demographics'); ?></h3>
              <ul>
              	<li class="first"><?php echo link_to(image_tag('/img/alter-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Age'), 'title'=>__('Age'))).__('Age'), '@get_analytics_content', array('query_string' => 'com=all&type=age&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
              	<li><?php echo link_to(image_tag('/img/gesch-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Gender'), 'title'=>__('Gender'))).__('Gender'), '@get_analytics_content', array('query_string' => 'com=all&type=gender&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
              	<li class="last"><?php echo link_to(image_tag('/img/bezi-nav.png', array('width' => '18', 'height'=>'18', 'alt'=>__('Relationship'), 'title'=>__('Relationship'))).__('Relationship'), '@get_analytics_content', array('query_string' => 'com=all&type=relationship&host_id='.$pHostId.'&date-from='.$pDateFrom.'&date-to='.$pDateTo.'&dealid='.$pDealId, 'class' => 'analytix-filter-link')); ?></li>
              </ul>
            </dd>
          </dl>
				</div>
      </div>
    </div>
    <div class="grboxbot"><span></span></div>
  </div>
</div>
