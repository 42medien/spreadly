<div class="clearfix">
<!--widecolumn start -->
	<div class="widecolumn alignright">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
			<?php if (!$pUrl || $pUrl == '' || $pUrl == null) {?>
				<?php echo __('No url statistics available'); ?>
			<?php } else { ?>
	      	<div class="graybox clearfix analyticsbox">
	        	<h2 class="analytics-title"><?php echo __('%community% Likes for %url%', array('%community%' => ucfirst($pCom), '%url%' => $pData['filter']['url']) ); ?></h2>
	          <div class="beshbox">
	          	<?php echo __('The chart shows all clicks on the Spread.ly button implemented on the indicated website during the above mentioned period of time.');?>
	          </div>
	         	<div class="textcenter analyticschart">
	          	<?php include_partial('analytics/chart_line_urls', array('pData' => $pData, 'pCommunity' => $pCom))?>
	          </div>
	          <h2 class="analytics-title kehntitle"><?php echo __('%community% key data', array('%community%' => ucfirst($pCom))); ?> <?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
	          <dl class="figuresbox clearfix">
	          	<dd class="alignleft figuresmid-box">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox">
	                  	<h3><?php echo __('Total value'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%likes% Likes', array('%likes%' => $pData['statistics']['total'][$pCom]['likes'])); ?></li>
	                      <li>› <?php echo __('%clickbacks% Clickbacks', array('%clickbacks%' => $pData['statistics']['total'][$pCom]['clickbacks'])); ?></li>
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
	                  	<h3><?php echo __('Mean value'); ?></h3>
	                    <ul>
	                    	<li>› <?php echo __('%likes% Likes / Day', array('%likes%' => $pData['statistics']['average'][$pCom]['likes'])); ?></li>
	                      <li>› <?php echo __('%clickbacks% Clickbacks / Day', array('%clickbacks%' => $pData['statistics']['average'][$pCom]['clickbacks'])); ?></li>
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
	                      <li>› <?php echo __('%clickbacks%% Clickback / Activity Ratio', array('%clickbacks%' => $pData['statistics']['ratio'][$pCom]['clickback_activities'])); ?></li>
	                    </ul>
	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	          </dl>
						<?php include_component('analytics','url_table', array('pCom' => $pCom, 'pFrom' => $pFrom, 'pTo' => $pTo, 'pUrl' => $pUrl)); ?>
	        </div>
	        <?php } //end if is url??>

      </div>
    </div>
    <div class="grboxbot"><span></span></div>
  </div>
 <!--widecolumn end-->
</div>