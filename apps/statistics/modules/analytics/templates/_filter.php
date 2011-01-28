<div class="filter">
	<form name="visit-history-form" id="visit-history-form" action="<?php echo url_for('@get_analytics_urls'); ?>">
  	<div class="clearfix">
  	  <div class="filter-item">
        <label for="host_id">Website</label>
        <select id="host_id" name="host_id">
          <?php foreach($pVerifiedDomains as $d): ?>
            <option <?php if($pHostId != null && $pHostId == $d->getId()) { echo 'selected="selected"'; } ?> value="<?php echo $d->getId() ?>"><?php echo $d->getDomain() ?></option>
          <?php endforeach; ?>
        </select>
      </div>

      <!--  div class="filter-item">
        <label for="date-to">Aggregation</label>
        <input type="radio" name="aggregation" value="daily" <?php if($pAggregation != null && $pAggregation == 'daily'): echo 'checked="checked"'; endif; ?>/>Tag
        <input type="radio" name="aggregation" value="weekly" <?php if($pAggregation != null && $pAggregation == 'weekly'): echo 'checked="checked"'; endif; ?> />Woche
        <input type="radio" name="aggregation" value="monthly" <?php if($pAggregation != null && $pAggregation == 'monthly'): echo 'checked="checked"'; endif; ?> />Monat
      </div -->

      <div class="filter-item">
        <label for="date-to"><?php echo __('Range') ?></label>
        <input type="text" id="date-from" name="date-from" value="<?php echo $pDateFrom ?>" size="8" />
        &ndash;<input type="text" id="date-to" name="date-to" value="<?php echo $pDateTo ?>" size="8" />
      </div>
      <div class="filter-item">
        <label for="submit">&nbsp;</label>
        <input type="submit" class="button positive" id="analytics-filter-button" value="Filter"/>
        <?php echo link_to('Reset', 'analytics/index', array('class' => 'button')) ?>
      </div>
    </div>
	</form>
</div>
