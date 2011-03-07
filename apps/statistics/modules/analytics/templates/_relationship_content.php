<div class="clearfix">
<!--widecolumn start -->
	<div class="widecolumn alignright">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
	      	<div class="graybox clearfix analyticsbox">
	        	<h2 class="analytics-title"><?php echo __('Relationship'); ?></h2>
	          <div class="beshbox">
	          	<?php echo __('The chart shows relationship status of the Spread.ly users on the indicated website during the above mentioned period of time.');?>
	          </div>
	         	<div class="textcenter analyticschart">
							<?php include_partial('analytics/chart_pie_relationship', array('pChartsettings' =>
								'{
									"width": 690,
									"height": 230,
									"margin": [20, 0, 30, 0],
									"plotsize": "80%",
									"bgcolor" : "#f6f6f6"
									}',
									'pData' => $pData)); ?>
	          </div>
	          <h2 class="analytics-title kehntitle"><?php echo __('Demograhic key data', array('%community%' => $pCom)); ?> <?php echo __('from %datefrom% - %dateto%', array('%datefrom%' => $pFrom, '%dateto%' => $pTo)); ?></h2>
	          <dl class="figuresbox clearfix">
	          	<dd class="alignleft figuresmid-box">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox"  id="age-distribution-table">
	                  	<h3><?php echo __('Relationship'); ?></h3>
	                    <ul>
												<li>› <?php echo __('%percent%% relationship', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["rel"])); ?></li>
												<li>› <?php echo __('%percent%% open', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["ior"])); ?></li>
												<li>› <?php echo __('%percent%% engaged', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["eng"])); ?></li>
												<li>› <?php echo __('%percent%% married', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["mar"])); ?></li>
												<li>› <?php echo __('%percent%% complicated', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["compl"])); ?></li>
												<li>› <?php echo __('%percent%% widowed', array('%percent%' => $pData["statistics"]["ratio"]["relationship"]["wid"])); ?></li>
	                    </ul>
	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	            <dd class="alignleft figuresthird-box">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox clearfix">
	                  	<h3><?php echo __('Age distribution');?></h3>
	                    <ul class="alignleft">
	                    	<li>› <?php echo __('%percent%% under 18', array('%percent%' => $pData["statistics"]["ratio"]["age"]["u_18"])); ?></li>
	                      <li>› <?php echo __('%percent%% 18 to 24', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_18_24"])); ?></li>
	                      <li>› <?php echo __('%percent%% 25 to 34', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_25_34"])); ?></li>
	                      <li>› <?php echo __('%percent%% 35 to 54', array('%percent%' => $pData["statistics"]["ratio"]["age"]["b_35_54"])); ?></li>
	                      <li>› <?php echo __('%percent%% over 55', array('%percent%' => $pData["statistics"]["ratio"]["age"]["o_55"])); ?></li>
	                    </ul>
	                    <div class="alignleft">
											<?php include_partial('analytics/chart_pie_age_activities', array('pChartsettings' =>
												'{
															"width": 300,
															"height": 130,
															"margin": [ 0, 0, 10, 40],
															"plotsize": "40%",
															"bgcolor" : "#e1e1e1"
													}',
													'pData' => $pData)); ?>
											</div>

	                  </div>
	                </div>
	              </div>
	              <div class="grayboxbot"><span></span></div>
	            </dd>
	            <dd class="alignleft figuresthird-box small-chart"">
	            	<div class="grayboxtop"><span></span></div>
	              <div class="grayboxmidl">
	              	<div class="grayboxmid">
	                	<div class="gesamtwertebox clearfix">
	                  	<h3><?php echo __('Gender distribution'); ?></h3>
	                    <ul class="alignleft">
	                    	<li>› <?php echo __('%percent%% male', array('%percent%' => $pData["statistics"]["ratio"]["gender"]["m"])); ?></li>
	                      <li>› <?php echo __('%percent%% female', array('%percent%' => $pData["statistics"]["ratio"]["gender"]["f"])); ?></li>
	                      <li>› <?php echo __('%percent%% unknown', array('%percent%' => $pData["statistics"]["ratio"]["gender"]["u"])); ?></li>
	                    </ul>
	                    <div class="alignleft">
											<?php include_partial('analytics/chart_pie_gender_activities', array('pChartsettings' =>
											'{
													"width": 300,
													"height": 130,
													"margin": [-30, 0, 10, 0],
													"plotsize": "40%",
													"bgcolor" : "#e1e1e1"
												}', 'pData' => $pData
											)); ?>
											</div>

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