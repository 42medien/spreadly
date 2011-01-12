<div class="filter">
	<form name="visit-history-form" id="visit-history-form" action="<?php echo url_for('visit_history/analytics'); ?>">
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
        <input type="submit" class="button positive" value="Filter"/>
        <?php echo link_to('Reset', 'analytics/index', array('class' => 'button')) ?>
      </div>
    </div>
    <div>
    	<?php echo link_to(__('Advanced options'), '/', array('id' => 'advanced-options-link')); ?><br/>
    	<div class="show clearfix" id="advanced-options-box">
				<strong><?php echo __('Category');?></strong> <?php echo link_to('All', '/', array('id' => 'check-cats-link'));?> | <?php echo link_to('None', '/', array('id' => 'uncheck-cats-link'));?>
				<ul id="filter-category-list">
					<li>
						<input type="checkbox" name="category" value="<?php echo __('Marketing');?>" class="left" id="cat-<?php echo __('Marketing'); ?>" checked="checked" />
						<label  class="left" for="cat-<?php echo __('Marketing'); ?>"><?php echo __('Marketing');?></label>
					</li>
					<li>
						<input class="left" type="checkbox" name="category" value="<?php echo __('Research');?>" id="cat-<?php echo __('Research'); ?>" checked="checked" />
						<label class="left" for="cat-<?php echo __('Research'); ?>"><?php echo __('Research');?></label>
					</li>
					<li>
						<input class="left" type="checkbox" name="category" value="<?php echo __('Accounting');?>" id="cat-<?php echo __('Accounting'); ?>" checked="checked" />
						<label class="left" for="cat-<?php echo __('Research'); ?>"><?php echo __('Accounting');?></label>
					</li>
				</ul>
    	</div>
    </div>
	</form>
</div>
