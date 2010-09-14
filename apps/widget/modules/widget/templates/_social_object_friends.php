<?php use_helper('Avatar'); ?>

<?php $lCounter = 0; ?>

<?php foreach($pFriends as $lUserId) { ?>
  
  <?php if($lCounter >= $pLimit) continue; ?>
  
  <?php $lUser = UserTable::getInstance()->find($lUserId); ?>
  
  <?php switch($pLimit) {
	  case(5): ?>
	  	<div class="friends_image left">
        <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
      </div>
	    <?php break;
	    
	  case(6): ?>
	    <div class="friends_image left">
        <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
	    </div>
      <?php break;
      
    case(7): ?>
      <div class="friends_image left">
        <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>	
	  	</div>
      <?php break;
      
    case(8): ?>
      <div class="friends_image left">
        <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>	
	    </div>
      <?php break;
      
      default: ?>
      <div class="friends_image left">
	  	  <?php echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => '')); ?>
	  	</div>
<?php } ?>
	
	<?php $lCounter++; ?>

	<?php } ?>