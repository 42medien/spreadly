<?php use_helper('Date'); ?>

<div id="sf_admin_container">
  <h1>Jobs in Queue</h1>
  
  <div id="sf_admin_header"></div>

  <div id="sf_admin_content">
    <div class="sf_admin_list">
      <table cellspacing="0">
      <thead>
        <tr>
          <th>_id</th>
          <th>type</th>
          <th>scheduled</th>
          <th>schedule_count</th>
          <th>scheduled_at</th>
          <th>started_at</th>
          <th>finisched_at</th>
          <th>priority</th>
          <th>error</th>
        </tr>
      </thead>
      <tfoot>
        <tr>
          <th colspan="9">&nbsp;</th>
        </tr>
      </tfoot>
      <tbody>
        <?php foreach ($jobs as $job): ?>
        <tr class="sf_admin_row odd">
          <td><?php echo $job->getId() ?></td>
          <td><?php echo get_class($job) ?></td>
          <td><?php echo $job->getScheduled() ? 'Yes' : 'No'; ?></td>
          <td><?php echo $job->getScheduleCount() ?></td>
          <td><?php echo $job->getScheduledAt() ? $job->getScheduledAt()->format('Y-m-d H:i:s') : 'n/a'; ?></td>
          <td><?php echo $job->getStartedAt() ? $job->getStartedAt()->format('Y-m-d H:i:s') : 'n/a'; ?></td>
          <td><?php echo $job->getFinishedAt() ? $job->getFinishedAt()->format('Y-m-d H:i:s') : 'n/a'; ?></td>
          <td><?php echo $job->getPriority() ?></td>
          <td><?php echo $job->getError() ? $job->getError() : 'n/a' ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>

  <ul class="sf_admin_actions">
    <li>
      <a href="/backend.php/domain/AddPointlessJobs/action">Add some pointless jobs</a>
    </li>
    </ul>
  </div>

  <div id="sf_admin_footer"></div>
</div>