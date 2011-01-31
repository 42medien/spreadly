<div class="filter">
	<form name="analytics-filter-form" id="analytics-filter-form" action="<?php echo url_for('@get_analytics_content'); ?>">
  	<div class="clearfix">
  	  <div class="filter-item">
        <label for="host_id"><?php echo __('Website'); ?></label>
        <select id="host_id" name="host_id">
          <?php foreach($pVerifiedDomains as $d): ?>
            <option <?php if($pHostId != null && $pHostId == $d->getId()) { echo 'selected="selected"'; } ?> value="<?php echo $d->getId() ?>"><?php echo $d->getDomain() ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="filter-item">
        <label for="date-to"><?php echo __('Range') ?></label>
        <input type="text" id="date-from" name="date-from" value="<?php echo $pDateFrom ?>" size="8" />
        &ndash;<input type="text" id="date-to" name="date-to" value="<?php echo $pDateTo ?>" size="8" />
      </div>
      <div class="filter-item">
        <label for="submit">&nbsp;</label>
        <input type="submit" class="button positive" id="analytics-filter-button" value="<?php echo __('Filter'); ?>"/>
        <?php echo link_to(__('Reset'), 'analytics/statistics', array('class' => 'button')) ?>
      </div>
    </div>
	</form>
</div>
