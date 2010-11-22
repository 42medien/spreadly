<table>
  <thead>
    <tr>
      <th>URI</th>
      <th>Seit</th>
      <th>PIs</th>
      <th>Activitys</th>
      <th>Trend</th>
      <th>Postive</th>
      <th>Trend</th>
      <th>Negative</th>
      <th>Trend</th>
    </tr>
  </thead>

  <tbody>
    <?php if(isset($lVisits)) { ?>
	    <?php foreach($lVisits as $lVisit) { ?>
		    <tr>
		      <td><?php echo $lVisit->getUri(); ?></td>
		      <td></td>
		      <td></td>
		      <td></td>
		      <td></td>
		      <td></td>
		      <td></td>
		      <td></td>
		      <td></td>
		    </tr>
		  <?php } ?>
		<?php } ?>
  </tbody>
</table>