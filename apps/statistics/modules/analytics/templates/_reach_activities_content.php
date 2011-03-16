<div class="clearfix">
<!--widecolumn start -->
	<div class="widecolumn alignright">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
	      	<div class="graybox clearfix analyticsbox">
	        	<h2 class="analytics-title"><?php echo __('Views on %community%', array('%community%' => $pCom)); ?></h2>
	          <div class="beshbox">
	          	<?php echo __('The chart shows coverage and media data concerning the usage of Spread.ly on the indicated site during the above mentioned period of time.');?>
	          </div>
	         	<div class="textcenter analyticschart">
	          	<?php include_partial('analytics/chart_line_range_views', array('pData' => $pData, 'pCommunity' => $pCom)); ?>
	          </div>
	          <h2 class="analytics-title kehntitle"><?php echo __('%community% range key data', array('%community%' => $pCom)); ?><?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => format_date($pFrom, 'D'), '%dateto%' => format_date($pTo, 'D'))); ?></h2>
	          <dl class="figuresbox clearfix">
	          	<dd class="alignleft figuresmid-box">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox">
	                  	<h3><?php echo __('Your likes had...'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%views% Views', array('%views%' => $pData['statistics']['total'][$pCom]['contacts'])); ?></li>
	                      <li>› <?php echo __('%likes% Likes', array('%likes%' => $pData['statistics']['total'][$pCom]['clickbacks'])); ?></li>
	                    </ul>
	                  	<h3><?php echo __('The response on these views was...'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => $pData['pis']['services'][$pCom]['cb'])); ?></li>
	                    </ul>
	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	            <dd class="alignleft figuresmid-box">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox">
	                  	<h3><?php echo __('Mean values'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%views% Views / Activity', array('%views%' => $pData['statistics']['ratio'][$pCom]['contacts_activities'])); ?></li>
	                      <li>› <?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => $pData['pis']['statistics']['average'][$pCom]['cb'])); ?></li>
	                    </ul>
	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	            <dd class="alignleft figuresmid-box no-margin">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox">
	                  	<h3><?php echo __('Percentage'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%clickbacks% Clickbacks per 100 Activities', array('%clickbacks%' => $pData['statistics']['ratio'][$pCom]['clickback_activities'])); ?></li>
	                    </ul>
	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	          </dl>
	        </div>
      </div>
    </div>
    <div class="grboxbot"><span></span></div>
  </div>
 <!--widecolumn end-->
</div>