<form name="analytics-filter-form" id="analytics-filter-form" action="<?php echo url_for('@get_analytics_content'); ?>">
<!--veryfied box start -->
	<div class="websiteinfo-outblock">
  	<div class="grboxtop"><span></span></div>
    <div class="grboxmid">
    	<div class="grboxmid-content">
				<div class="graybox clearfix">
        	<div class="resetblock alignright">
          	<a href="#" class="active" id="analytics-filter-button"><span>Filter</span></a><a href="<?php echo url_for('analytics/statistics');?>"><span>Reset</span></a>
          </div>
          <div class="alignleft webblock">
          	<h2 class="webtitle">Website</h2>
            <label id="websel" for="host_id">
            	<select class="custom-select" id="host_id" name="host_id">
						  	<?php foreach($pVerifiedDomains as $d): ?>
						    	<option <?php if($pHostId != null && $pHostId == $d->getId()) { echo 'selected="selected"'; } ?> value="<?php echo $d->getId() ?>"><?php echo $d->getDomain() ?></option>
						    <?php endforeach; ?>
              </select>
            </label>
          </div>
         	<div class="alignleft zeitraumblock">
          	<h2 class="webtitle">Zeitraum</h2>
            <label class="textfield-whtmid"><span><input type="text" id="date-from" class="wd172" name="date-from" value="<?php echo $pDateFrom ?>" /></span></label><span class="alignleft deshline"> - </span><label class="textfield-whtmid"><span><input type="text" class="wd172" id="date-to" name="date-to" value="<?php echo $pDateTo ?>" /></span></label>
          </div>
        </div>
      </div>
    </div>
  	<div class="grboxbot"><span></span></div>
  </div>
  <!--veryfied box end -->
</form>
