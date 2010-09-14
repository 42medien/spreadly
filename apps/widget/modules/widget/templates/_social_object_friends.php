<?php use_helper('Avatar'); ?>

<?php $lCounter = 0; ?>

<?php foreach($pFriends as $lUserId) { ?>
  
  <?php if($lCounter >= $pLimit) continue; ?>
  
  <?php $lUser = UserTable::getInstance()->find($lUserId); ?>
  
  <?php switch($pLimit) {
	  case(5):
      echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => ''));
	    break;
	    
	  case(6):
      echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => ''));
	    break;
	    
	  case(7):
      echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => ''));	
	  	break;
	  	
	  case(8):
      echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => ''));	
	    break;
	    
	  default:
	  	echo avatar_tag($lUser->getDefaultAvatar(), 30, array('alt' => $lUser->getFullname(), 'title' => $lUser->getFullname(), 'class' => '', 'rel' => ''));
	} ?>
	
	<?php $lCounter++; ?>

	<?php } ?>