<form name="visit-history-form" class="clearfix" id="visit-history-form" action="/visit_history/summary">
  <div class="form-area">
	  <label for="date-from">von</label>
	  <input type="text" name="date-from" id="date-from" value="<?php echo date('Y-m-d G:i')?>"/>
	  <label for="date-to">bis</label>
	  <input type="text" name="date-to" id="date-to" value="<?php echo date('Y-m-d G:i')?>"/>
  </div>
  <div class="form-area">
	  <label for="cult">Sprache</label>
	  <select name="cult" size="3">
	    <option value="all">Alle</option>
	    <option value="en">Englisch</option>
	    <option value="de">Deutsch</option>
	  </select>
  </div>
  <div class="form-area">
	  <label for="version">Typ</label>
	  <select name="version" size="3">
	    <option value="all">Alle</option>
	    <option value="like">Like</option>
	    <option value="full">Like/Dislike</option>
	  </select>
  </div>
  <div class="form-area">
	  <label for="search">Domain</label>
	  <input name="host" type="text" value="" />
  </div>
  <div class="form-area">
    <input type="submit" value="absenden"/>
  </div>
</form>
<table>
  <thead>
    <tr>
      <th>Domain</th>
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
	    <?php foreach($lVisits as  $lVisit) { ?>
		    <tr>
		      <td class="domain"><a href="/visit_history/detail?id=<?php echo $lVisit['_id']['host'];?>"><?php echo $lVisit['_id']['host']; ?></a></td>
		      <td><?php //echo $lVisit->getC(); ?></td>
		      <td><?php echo $lVisit['value']['pis']; ?></td>
		      <td><?php  echo $lVisit['value']['total'];?></td>
		      <td><?php echo "" ?></td>
		      <td><?php echo $lVisit['value']['likes']; ?></td>
		      <td></td>
		      <td><?php echo $lVisit['value']['dislikes']; ?></td>
		      <td></td>
		    </tr>
		  <?php } ?>
  </tbody>
</table>